<link rel="stylesheet" href="popup_style.css">

<?php
error_reporting(0);
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

  require_once('../../assets/constants/config.php');

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['btn_save'])) {
      $name = htmlspecialchars($_POST['name']);
      $status = htmlspecialchars($_POST['percentage']);
        $id= $_SESSION['id'];
  
        $stmt = $conn->prepare("INSERT INTO `tbl_tax`(`name`, `percentage`) VALUES (:name,:percentage)");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':percentage', $status);
    
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
      $status = htmlspecialchars($_POST['percentage']);

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