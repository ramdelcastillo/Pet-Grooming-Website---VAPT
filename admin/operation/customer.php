<link rel="stylesheet" href="popup_style.css">


<?php
error_reporting(0);
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

require_once('../../assets/constants/config.php');
//print_r($_POST);
try {
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['btn_save']))
{
  

  $stmt = $conn->prepare("INSERT INTO tbl_customer (cust_name,cust_mob,cust_email,cust_address, state, gstin) VALUES (:cust_name,:cust_mob,:cust_email,:cust_address,:state,:gstin)");
  $stmt->bindParam(':cust_name', $_POST['custname']);
    $stmt->bindParam(':cust_mob',$_POST['customer_mobno']);

  $stmt->bindParam(':cust_email', $_POST['c_email']);
   $stmt->bindParam(':cust_address', $_POST['c_address']);
    $stmt->bindParam(':state', $_POST['state']);
      $stmt->bindParam(':gstin', $_POST['gstin']);
  $stmt->execute();


    $_SESSION['success'] = "Customer Added Succesfully";
      header('location:../view_customer.php');
       exit;

}


if(isset($_POST['btn_save1']))
{
  

  $stmt = $conn->prepare("INSERT INTO tbl_customer (cust_name,cust_mob,cust_email,cust_address, state, gstin) VALUES (:cust_name,:cust_mob,:cust_email,:cust_address,:state,:gstin)");
  $stmt->bindParam(':cust_name', $_POST['custname']);
    $stmt->bindParam(':cust_mob',$_POST['customer_mobno']);

  $stmt->bindParam(':cust_email', $_POST['c_email']);
   $stmt->bindParam(':cust_address', $_POST['c_address']);
    $stmt->bindParam(':state', $_POST['state']);
      $stmt->bindParam(':gstin', $_POST['gstin']);
  $stmt->execute();
    //echo "<script>alert(' Record Successfully Added');</script>";

  $_SESSION['reply'] = "003";
 ?>
 <div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Success 
    </h1>
    <p>Record Successfully Added</p>
    <p>
    
     <?php echo "<script>setTimeout(\"location.href = '../estimate.php';\",1500);</script>"; ?>
    </p>
  </div>
</div>
</div>

      <?php 

}


if(isset($_POST['btn_save2']))
{
  

  $stmt = $conn->prepare("INSERT INTO tbl_customer (cust_name,cust_mob,cust_email,cust_address, state, gstin) VALUES (:cust_name,:cust_mob,:cust_email,:cust_address,:state,:gstin)");
  $stmt->bindParam(':cust_name', $_POST['custname']);
    $stmt->bindParam(':cust_mob',$_POST['customer_mobno']);

  $stmt->bindParam(':cust_email', $_POST['c_email']);
   $stmt->bindParam(':cust_address', $_POST['c_address']);
    $stmt->bindParam(':state', $_POST['state']);
      $stmt->bindParam(':gstin', $_POST['gstin']);
  $stmt->execute();
    //echo "<script>alert(' Record Successfully Added');</script>";

  $_SESSION['reply'] = "003";
 ?>
 <div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Success 
    </h1>
    <p>Record Successfully Added</p>
    <p>
    
     <?php echo "<script>setTimeout(\"location.href = '../order.php';\",1500);</script>"; ?>
    </p>
  </div>
</div>
</div>

      <?php 

}



if(isset($_POST['btn_update']))
{
  //$id=$_GET['id'];
  //echo "string";
 
  $stmt = $conn->prepare("UPDATE tbl_customer SET cust_name=:cust_name,cust_mob=:cust_mob,cust_email=:cust_email,cust_address=:cust_address , state=:state ,gstin=:gstin WHERE cust_id=:cust_id");
  /*$sql = "UPDATE candidate SET fname=:fname,lname=:lname,ward=:ward,age=:age,gender=:gender,city=:city,qualification=:qualification,m_status=:m_status,image=:website_logo WHERE id='".$_GET['id']."'";
  */  
  $stmt->bindParam(':cust_name', $_POST['custname']);
    $stmt->bindParam(':cust_mob', $_POST['customer_mobno']);

  $stmt->bindParam(':cust_email', $_POST['c_email']);
  $stmt->bindParam(':cust_address', $_POST['c_address']);
   $stmt->bindParam(':state', $_POST['state']);
    $stmt->bindParam(':gstin', $_POST['gstin']);
    $stmt->bindParam(':cust_id', $_POST['id']);

 
 $execute=$stmt->execute();
  if($execute==true)
  {
 
    $_SESSION['success'] = "Customer Updated Succesfully";
      header('location:../view_customer.php');
       exit;

}
}

if(isset($_GET['id']))
{
  $stmt = $conn->prepare("DELETE FROM tbl_customer WHERE cust_id = :cust_id");
  // $stmt = $conn->prepare("UPDATE tbl_product SET delete_status=1 WHERE id=:id");
  $stmt->bindParam(':cust_id', $_GET['id']);
  $stmt->execute();
 
    $_SESSION['success'] = "Customer Deleted Succesfully";
      header('location:../view_customer.php');
       exit;
}


if(isset($_POST['del_id']))
{
  $stmt = $conn->prepare("DELETE FROM tbl_customer WHERE cust_id = :cust_id");
  // $stmt = $conn->prepare("UPDATE tbl_product SET delete_status=1 WHERE id=:id");
  $stmt->bindParam(':cust_id', $_POST['del_id']);
  $stmt->execute();
 

    $_SESSION['success'] = "Customer Deleted Succesfully";
      header('location:../view_customer.php');
       exit;
}
           
}catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}

}else{

header("location:../");

}

?>
