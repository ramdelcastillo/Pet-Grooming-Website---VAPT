<link rel="stylesheet" href="popup_style.css">

<?php
error_reporting(0);
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {


  require_once '/var/www/html/vendor/autoload.php';
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
      $name = htmlspecialchars($_POST['name']);
      $status = htmlspecialchars($_POST['status']);
      $id = $_SESSION['id'];

      $stmt = $conn->prepare("
          SELECT id FROM tbl_product_grp
          WHERE name = ? AND delete_status = 0
      ");

      $stmt->execute([$name]);
      $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$duplicate) {
        $allowed = [
          1 => 'Active',
          2 => 'Deactive'
        ];

        $delete_status = 0;
        $for = 0;

        $status_id = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        if ($status_id === false || !array_key_exists($status_id, $allowed)) {
          $_SESSION['error'] = "Invalid status value.";
          header('Location: ../category.php');
          exit;
        }

        $status = $allowed[$status_id];

        $stmt = $conn->prepare("INSERT INTO `tbl_product_grp`(`name`, `status`, `user_id`, `for`, `delete_status` ) VALUES (:name, :status, :user_id, :for, :delete_status)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $id);
        $stmt->bindParam(':for', $delete_status);
        $stmt->bindParam(':delete_status', $for);
        $stmt->execute();

        $_SESSION['success'] = "Category Added Succesfully";
        header('location:../category.php');
        exit;
      } else if ($duplicate) {
        $_SESSION['error'] = "Category name already exists";
        header('location:../category.php');
        exit;
      } else {
        $_SESSION['error'] = "Unexpected input detected.";
        header('location:../category.php');
        exit;
      }

    }

    if (isset($_POST['btn_edit'])) {
      $name = htmlspecialchars($_POST['name']);
      $status = htmlspecialchars($_POST['status']);
      $id = $_POST['id'];

      $stmt = $conn->prepare("
          SELECT name FROM tbl_product_grp
          WHERE id = ? and delete_status = 0
      ");

      $stmt->execute([$id]);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$record) {
        $_SESSION['error'] = "Error";
        header('Location: ../category.php');
        exit;
      }

      $stmt = $conn->prepare("
          SELECT id FROM tbl_product_grp
          WHERE name = ? AND id != ? AND delete_status = 0
      ");
      $stmt->execute([$name, $id]);
      $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$duplicate) {
        $allowed = [
          1 => 'Active',
          2 => 'Deactive'
        ];

        $status_id = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        if ($status_id === false || !array_key_exists($status_id, $allowed)) {
          $_SESSION['error'] = "Invalid status value.";
          header('Location: ../category.php');
          exit;
        }

        $status = $allowed[$status_id];

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
      } elseif ($duplicate) {
        $_SESSION['error'] = "Tax name already exists";
        header('location:../category.php');
        exit;
      } else {
        $_SESSION['error'] = "Unexpected input detected.";
        header('location:../category.php');
        exit;
      }
    }

    if (isset($_POST['del_id'])) {
      $id = $_POST['del_id'];

      $stmt = $conn->prepare("
          SELECT name FROM tbl_product_grp
          WHERE id = ? and delete_status = 0
      ");

      $stmt->execute([$id]);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$record) {
        $_SESSION['error'] = "Error";
        header('Location: ../category.php');
        exit;
      }

      $stmt = $conn->prepare("UPDATE tbl_product_grp SET delete_status=1 WHERE id=:id");
      $stmt->bindParam(':id', $id);
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