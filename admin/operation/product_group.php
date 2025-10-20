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
      $status = htmlspecialchars($_POST['status']);
      $id = $_SESSION['id'];

      $stmt = $conn->prepare("INSERT INTO `tbl_product_grp`(`name`, `status`, `user_id`) VALUES (:name, :status, :user_id)");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':user_id', $id);
      $stmt->execute();

      $_SESSION['success'] = "Category Added Succesfully";
      header('location:../category.php');
      exit;
    }

    if (isset($_POST['btn_edit'])) {
      $name = htmlspecialchars($_POST['name']);
      $status = htmlspecialchars($_POST['status']);

      $stmt = $conn->prepare("UPDATE tbl_product_grp SET name=:name, status=:status WHERE id=:id");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':id', $_POST['id']);
      $execute = $stmt->execute();

      if ($execute == true) {
        $_SESSION['success'] = "Category Updated Succesfully";
        header('location:../category.php');
        exit;
      }
    }

   
    if (isset($_POST['del_id'])) {
      $stmt = $conn->prepare("UPDATE tbl_product_grp SET delete_status=1 WHERE id=:id");
      $stmt->bindParam(':id', $_POST['del_id']);
      $stmt->execute();

      $_SESSION['success'] = "Category Deleted Succesfully";
      header('location:../category.php');
      exit;
    }

  } catch (PDOException $e) {
    echo "Connection failed: " . htmlspecialchars($e->getMessage());
  }

} else {
  header("location:../");
  exit;
}
?>