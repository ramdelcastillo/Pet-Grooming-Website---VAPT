<link rel="stylesheet" href="popup_style.css">

<?php
error_reporting(0);
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

  require_once '/var/www/html/vendor/autoload.php';  
  $dotenv = Dotenv\Dotenv::createImmutable('/var/www/env'); 
  $dotenv->load();

  $servername = $_ENV['DB_HOST'];
  $username   = $_ENV['DB_USER'];
  $password  = $_ENV['DB_PASS'];
  $dbname     = $_ENV['DB_NAME'];

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['btn_save'])) {
      $name = htmlspecialchars($_POST['name']);

      $stmt = $conn->prepare("
          SELECT EXISTS(
              SELECT 1 FROM tbl_tax 
              WHERE name = ? AND delete_status = 0
          ) AS name_exists
      ");

      $stmt->execute([$name]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result['name_exists']) {
          $_SESSION['error'] = "Tax name already exists";
          header('location:../tax.php');
          exit;
      }

      $status = htmlspecialchars($_POST['percentage']);
      $delete_status = 0;

      $percentage = (int) $status;

      $percentage = filter_var(
        $_POST['percentage'],
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 0]]
      );

      if ($percentage === false) {
          $_SESSION['error'] = "Invalid tax percentage";
          header('location:../tax.php');
          exit;
      }



      

      $id= $_SESSION['id'];
  
      $stmt = $conn->prepare("INSERT INTO `tbl_tax`(`name`, `percentage`, `delete_status`) VALUES (:name,:percentage,:delete_status)");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':percentage', $status);
      $stmt->bindParam(':delete_status', $delete_status);
    
      $stmt->execute();
      //echo "<script>alert(' Record Successfully Added');</script>";

      $_SESSION['success'] = "Tax Added Succesfully";
      header('location:../tax.php');
      exit;

    }
    if (isset($_POST['btn_edit'])) {
      //$id=$_GET['id'];
      //echo "string";
      $name = htmlspecialchars($_POST['name']);

      $stmt = $conn->prepare("
          SELECT EXISTS(
              SELECT 1 FROM tbl_tax 
              WHERE name = ? AND delete_status = 0
          ) AS name_exists
      ");

      $stmt->execute([$name]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result['name_exists']) {
          $_SESSION['error'] = "Tax name already exists";
          header('location:../tax.php');
          exit;
      }

      $status = htmlspecialchars($_POST['percentage']);

      $percentage = (int) $status;

      $percentage = filter_var(
        $_POST['percentage'],
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 0]]
      );

      if ($percentage === false) {
          $_SESSION['error'] = "Invalid tax percentage";
          header('location:../tax.php');
          exit;
      }

      $stmt = $conn->prepare("UPDATE tbl_tax SET name=:name,percentage=:percentage  WHERE id=:id");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':percentage', $status);
      $stmt->bindParam(':id', $_POST['id']);


      $execute = $stmt->execute();
      if ($execute == true) {

        $_SESSION['success'] = "Tax Updated Succesfully";
      header('location:../tax.php');
      exit;
    }
  }

    if (isset($_POST['del_id'])) {
      //$stmt = $conn->prepare("DELETE FROM customers WHERE id = :id");
      $stmt = $conn->prepare("UPDATE tbl_tax SET delete_status=1 WHERE id=:id");
      $stmt->bindParam(':id', $_POST['del_id']);
      $stmt->execute();


     $_SESSION['success'] = "Tax Deleted Succesfully";
      header('location:../tax.php');
      exit;
    }
  } catch (PDOException $e) {
    echo "Connection failed: " . htmlspecialchars($e->getMessage());
  }
} else {

  header("location:../");
}

?>