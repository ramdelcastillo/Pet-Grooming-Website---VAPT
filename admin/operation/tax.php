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

    if (isset($_POST['btn_save'])) {
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../tax.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

      $name = trim($_POST['name']);
      $percentage_raw = $_POST['percentage'];

      $errors = [];

      if (empty($name)) {
        $errors[] = "Tax name is required";
      }

      if (!filter_var($percentage_raw, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]])) {
        $errors[] = "Invalid tax percentage: must be a non-negative integer";
      }

      if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('location:../tax.php');
        exit;
      }

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

      $delete_status = 0;
      $percentage = (int) $percentage_raw;

      $stmt = $conn->prepare("
      INSERT INTO tbl_tax (name, percentage, delete_status)
      VALUES (:name, :percentage, :delete_status)
      ");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':percentage', $percentage);
      $stmt->bindParam(':delete_status', $delete_status);
      $stmt->execute();

      $_SESSION['success'] = "Tax added successfully";
      header('location:../tax.php');
      exit;

    }
    if (isset($_POST['btn_edit'])) {
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../tax.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

      $id = $_POST['id'];
      $name = $_POST['name'];

      $stmt = $conn->prepare("
        SELECT name FROM tbl_tax 
        WHERE id = ? AND delete_status = 0
      ");
      $stmt->execute([$id]);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$record) {
        $_SESSION['error'] = "Error";
        header('location:../tax.php');
        exit;
      }

      $stmt = $conn->prepare("
        SELECT EXISTS(
            SELECT 1 FROM tbl_tax 
            WHERE name = ? AND id != ? AND delete_status = 0
        ) AS duplicate_exists
      ");
      $stmt->execute([$name, $id]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result['duplicate_exists']) {
        $_SESSION['error'] = "Tax name already exists";
        header('location:../tax.php');
        exit;
      }

      $percentage_raw = $_POST['percentage'];
      $percentage = filter_var($percentage_raw, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]);

      if ($percentage === false) {
        $_SESSION['error'] = "Invalid tax percentage";
        header('location:../tax.php');
        exit;
      }

      $stmt = $conn->prepare("
        UPDATE tbl_tax 
        SET name = :name, percentage = :percentage 
        WHERE id = :id
      ");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':percentage', $percentage);
      $stmt->bindParam(':id', $id);
      $stmt->execute();

      $_SESSION['success'] = "Tax Updated Successfully";
      header('location:../tax.php');
      exit;

    }

    if (isset($_POST['del_id'])) {
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../tax.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

      $stmt = $conn->prepare("
        UPDATE tbl_tax
        SET delete_status = 1
        WHERE id = :id AND delete_status = 0
      ");
      $stmt->bindParam(':id', $_POST['del_id']);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        $_SESSION['error'] = "Error";
        header('location:../tax.php');
        exit;
      }

      $_SESSION['success'] = "Tax Deleted Successfully";
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