<link rel="stylesheet" href="popup_style.css">

<?php
error_reporting(0);
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

  require_once '/var/www/vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::createImmutable('/var/www/env');
  $dotenv->load();

  $servername = $_ENV['DB_HOST'];
  $username = $_ENV['DB_USER'];
  $password = $_ENV['DB_PASS'];
  $dbname = $_ENV['DB_NAME'];

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    if (isset($_POST['add_stock'])) {
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../productdisplay.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

      // Form se values le rahe hain
      $id = $_POST['id'];

      $new_stock = $_POST['openning_stock'];

      if (!filter_var($new_stock, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 10000]])) {
        $_SESSION['error'] = "Stock addition must be a whole number between 1 and 10,000.";
        header('location:../productdisplay.php');
        exit;
      }

      $query = "SELECT openning_stock FROM tbl_product WHERE id = :id AND exp = 0";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $current_stock = $stmt->fetchColumn();

      if ($current_stock === false) {
        $_SESSION['error'] = "Product not found.";
        header('location:../productdisplay.php');
        exit;
      }

      $updated_stock = $current_stock + $new_stock;

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
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../productdisplay.php');
        exit;
      }

      unset($_SESSION['csrf_token']);


      $id = $_SESSION['id'];
      $openning_stock = 0;


      $gst = $_POST['gst'];

      $expl = implode(',', $gst);


      $selling_cost = '';
      if ($_POST['exp'] == 1) {
        $selling_cost = $_POST['unit_price'];
      } else if ($_POST['exp'] == 0) {
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
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../productdisplay.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

      $id = $_POST['id'];
      $group_id = $_POST['group_id'];
      $name = trim($_POST['name']);
      $pid = htmlspecialchars($_POST['pid']);
      $exp_date = $_POST['exp_date'];
      $gst_array = $_POST['gst'] ?? [];
      $gst = isset($gst_array[0]) ? (int) $gst_array[0] : 0;
      $hsn = $_POST['hsn'];
      $details = $_POST['details'];
      $exp = (int) $_POST['exp'];
      $purchase_price = (float) $_POST['purchase_price'];
      $unit_price = (float) $_POST['unit_price'];
      $min_stock = (int) $_POST['min_stock'];

      $errors = [];

      if (!preg_match("/^\d{5,6}$/", $hsn)) {
        $errors[] = 'Invalid HSN: Must be a 5–6 digit numeric code (no spaces or symbols)';
      }
      if (strlen($name) > 1500) {
        $errors[] = 'Invalid product name';
      }
      if (strlen($details) > 2500) {
        $errors[] = 'Invalid product name';
      }
      if (!preg_match('/^[01]$/', $exp)) {
        $errors[] = 'Invalid value for exp: Must be 0 or 1';
      }
      if ((!filter_var($purchase_price, FILTER_VALIDATE_FLOAT) && $purchase_price !== '0') || $purchase_price > 1000000) {
        $errors[] = 'Invalid purchase price: Must be a number not exceeding 1,000,000';
      }

      if ((!filter_var($unit_price, FILTER_VALIDATE_FLOAT) && $unit_price !== '0') || $unit_price > 1000000) {
        $errors[] = 'Invalid unit price: Must be a number not exceeding 1,000,000';
      }
      if ($min_stock < 1 || $min_stock > 10000) {
        $errors[] = 'Invalid minimum stock: Must be between 1 and 10,000';
      }
      if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('location:../productdisplay.php');
        exit();
      }

      $d = DateTime::createFromFormat('Y-m-d', $exp_date);
      if (!$d || $d->format('Y-m-d') !== $exp_date) {
        $exp_date = null;
      }

      $stmt = $conn->prepare("
      SELECT
        (SELECT COUNT(*) FROM tbl_product WHERE id = ? AND delete_status = 0) AS product_exists,
        (SELECT COUNT(*) FROM tbl_product_grp WHERE id = ? AND delete_status = 0) AS group_exists,
        (SELECT COUNT(*) FROM tbl_tax WHERE id = ? AND delete_status = 0) AS gst_exists,
        (SELECT COUNT(*) FROM tbl_product WHERE name = ? AND id != ? AND delete_status = 0) AS duplicate_exists
    ");
      $stmt->execute([$id, $group_id, $gst, $name, $id]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result['product_exists'] == 0) {
        $_SESSION['error'] = "Error: Product not found";
        header('location:../productdisplay.php');
        exit;
      }
      if ($result['group_exists'] == 0) {
        $_SESSION['error'] = "Error: Product group not found";
        header('location:../productdisplay.php');
        exit;
      }
      if ($result['gst_exists'] == 0) {
        $_SESSION['error'] = "Error: Invalid GST";
        header('location:../productdisplay.php');
        exit;
      }
      if ($result['duplicate_exists'] > 0) {
        $_SESSION['error'] = "Product name already exists";
        header('location:../productdisplay.php');
        exit;
      }

      $stmt = $conn->prepare("
      SELECT percentage FROM tbl_tax WHERE id = ? AND delete_status = 0
      ");
      $stmt->execute([$gst]);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);
      $perc = (int) $record['percentage'];


      if ($exp === 0) { // Product
        $purchase_gst = $purchase_price + ($purchase_price * $perc / 100);
        $selling_gst = $unit_price + ($unit_price * $perc / 100);
      } else { // Service
        $purchase_gst = $purchase_price; // or leave as is
        $selling_gst = $unit_price;
      }

      // Decide on final selling price based on type (Product or Service)
      $final_selling_cost = ($exp == '1') ? $unit_price : $selling_gst;

      try {
        $stmt = $conn->prepare("UPDATE tbl_product SET 
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
            selling_gst = :selling_gst,
            min_stock = :min_stock
        WHERE id = :id");

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
        $stmt->bindParam(':min_stock', $min_stock);
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
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../productdisplay.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

      $id = $_POST['del_id'];

      $stmt = $conn->prepare("
        UPDATE tbl_product
        SET delete_status = 1
        WHERE id = ? AND delete_status = 0
      ");
      $stmt->execute([$id]);

      if ($stmt->rowCount() == 0) {
        $_SESSION['error'] = "Error: Product not found or already deleted";
        header('location:../productdisplay.php');
        exit;
      }

      $_SESSION['success'] = "Product Deleted Successfully";
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