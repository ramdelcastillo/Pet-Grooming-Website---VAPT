<link rel="stylesheet" href="popup_style.css">

<?php
error_reporting(0);
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

  require_once('../../assets/constants/config.php');

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


   
if (isset($_POST['add_stock'])) {
    // Form se values le rahe hain
    $id = $_POST['id'];
    $new_stock = $_POST['openning_stock'];
    $old_stock = $_POST['old_stock'];

    // Naya stock update karna
    $updated_stock = $new_stock + $old_stock;

    try {
        // PDO query execute karna
        $query = "UPDATE tbl_product SET openning_stock = :updated_stock WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':updated_stock', $updated_stock, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Stock Updated Succesfully";
      header('location:../productdisplay.php');
      exit;
        } else {
            echo "<script>alert('Stock update failed!');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



    if (isset($_POST['btn_save'])) {
        
      
    $id=$_SESSION['id'];
      $openning_stock = 0;
      
      
      $gst=$_POST['gst'];

      $expl=implode(',',$gst);
      
   
      $selling_cost= '';
      if($_POST['exp']==1){
          $selling_cost= $_POST['unit_price'];
      }else  if($_POST['exp']==0){
          $selling_cost = $_POST['selling_gst'];
      }
      
      
      $stmt = $conn->prepare("INSERT INTO tbl_product (pid, name,unit_price,purchase_price,openning_stock,currentdate,group_id,details,user_id, gst,purchase_gst, selling_gst, exp,exp_date,hsn) VALUES (:pid,:name,:unit_price,:purchase_price,:openning_stock, :created_date,:group_id,:details,:user_id, :gst, :purchase_gst, :selling_gst,:exp,:exp_date,:hsn)");
      $stmt->bindParam(':pid', htmlspecialchars($_POST['pid']));
      $stmt->bindParam(':name', htmlspecialchars($_POST['name']));
      $stmt->bindParam(':unit_price', htmlspecialchars($_POST['unit_price']));

      $stmt->bindParam(':purchase_price', htmlspecialchars($_POST['purchase_price']));
      $stmt->bindParam(':openning_stock', htmlspecialchars($openning_stock));
      $stmt->bindParam(':created_date', htmlspecialchars(date('Y-m-d')));
      $stmt->bindParam(':group_id', htmlspecialchars($_POST['group_id']));
      $stmt->bindParam(':details', htmlspecialchars($_POST['details']));
  
       $stmt->bindParam(':user_id', $id);
        $stmt->bindParam(':gst', $expl);
        $stmt->bindParam(':purchase_gst', htmlspecialchars($_POST['purchase_gst']));
        $stmt->bindParam(':selling_gst', htmlspecialchars($selling_cost));
         $stmt->bindParam(':exp', htmlspecialchars($_POST['exp']));
          $stmt->bindParam(':exp_date', htmlspecialchars($_POST['exp_date']));
          
            $stmt->bindParam(':hsn', htmlspecialchars($_POST['hsn']));
    //   $stmt->bindParam(':image', htmlspecialchars($img));

      $stmt->execute();

      //echo "<script>alert(' Record Successfully Added');</script>";
      $last_inserted_id = htmlspecialchars($conn->lastInsertId());

     $_SESSION['success'] = "Product Added Succesfully";
      header('location:../productdisplay.php');
      exit;

    }
    
    // print_r($_POST);
   if (isset($_POST['btn_edit'])) {

    $id = $_POST['id'];
    $pid = htmlspecialchars($_POST['pid']);
    $name = htmlspecialchars($_POST['name']);
    $hsn = htmlspecialchars($_POST['hsn']);
    $group_id = $_POST['group_id'];
    $purchase_price = $_POST['purchase_price'];
    $unit_price = $_POST['unit_price'];
    $details = htmlspecialchars($_POST['details']);
    $exp = $_POST['exp'];
    $exp_date = !empty($_POST['exp_date']) ? $_POST['exp_date'] : null;
  
    $gst_array = $_POST['gst'] ?? [];
    $gst = implode(',', $gst_array); // convert array to comma-separated string
    $purchase_gst = $_POST['purchase_gst'];
    $selling_gst = $_POST['selling_gst'];

    // Decide on final selling price based on type (Product or Service)
    $final_selling_cost = ($exp == '1') ? $unit_price : $selling_gst;

    try {
        $stmt = $conn->prepare("UPDATE tbl_product SET 
            pid = :pid,
            name = :name,
            hsn = :hsn,
            group_id = :group_id,
            purchase_price = :purchase_price,
            unit_price = :unit_price,
            details = :details,
            exp = :exp,
            exp_date = :exp_date,
          
            gst = :gst,
            purchase_gst = :purchase_gst,
            selling_gst = :selling_gst
        WHERE id = :id");

        $stmt->bindParam(':pid', $pid);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':hsn', $hsn);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->bindParam(':purchase_price', $purchase_price);
        $stmt->bindParam(':unit_price', $final_selling_cost);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':exp', $exp);
        $stmt->bindParam(':exp_date', $exp_date);
       
        $stmt->bindParam(':gst', $gst);
        $stmt->bindParam(':purchase_gst', $purchase_gst);
        $stmt->bindParam(':selling_gst', $final_selling_cost);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Product updated successfully.";
            header("Location: ../productdisplay.php"); 
            exit();

        } else {
            $_SESSION['error'] = "Something went wrong. Try again.";
            header("Location: ../update_product.php?id=" . $id);
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "DB Error: " . $e->getMessage();
        header("Location: ../update_product.php?id=" . $id);
        exit();
    }
}

    if (isset($_POST['del_id'])) {
      //$stmt = $conn->prepare("DELETE FROM customers WHERE id = :id");
      $stmt = $conn->prepare("UPDATE tbl_product SET delete_status=1 WHERE id=:id");
      $stmt->bindParam(':id', htmlspecialchars($_POST['del_id']));
      $stmt->execute();

       $_SESSION['success'] = "Product Deleted Succesfully";
      header('location:../productdisplay.php');
      exit;
    }
  } catch (PDOException $e) {
    echo "Connection failed: " . htmlspecialchars($e->getMessage());
  }
} else {

  header("location:../");
}

?>