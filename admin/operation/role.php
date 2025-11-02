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
    // print_r($_POST); exit;
    if (isset($_POST['btn_save'])) {
      extract($_POST);
      $id = $_POST['id'];

      $stmt = $conn->prepare("
          SELECT id FROM tbl_groups
          WHERE name = ? AND id != ? AND delete_status = 0
      ");

      $stmt->execute([$assign_name, $id]);
      $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$duplicate) {
        $stmt = $conn->prepare("insert into tbl_groups(name,description)values('$assign_name','$description')");
        $stmt->execute();
        $last_id = $conn->lastInsertId();
        $id = $last_id;
        $checkItem = $_POST["checkItem"];
        //print_r($_POST);exit;
        $a = count($checkItem);
        for ($i = 0; $i < $a; $i++) {
          $stmt = $conn->prepare("insert into tbl_permission_role(permission_id,group_id)values('$checkItem[$i]','$id')");
          $stmt->execute();
        }

        $_SESSION['success'] = "Role Added Succesfully";
        header('location:../view_role.php');
        exit;
      } elseif ($duplicate) {
        $_SESSION['error'] = "Role name already exists";
        header('location:../view_role.php');
        exit;
      } else {
        $_SESSION['error'] = "Unexpected input";
        header('location:../view_role.php');
        exit;
      }

    }
    if (isset($_POST['btn_edit'])) {
      extract($_POST);
      $id = $_POST['id'];

      $stmt = $conn->prepare("
        SELECT name FROM tbl_groups
        WHERE id = ? AND delete_status = 0
      ");

      $stmt->execute([$id]);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$record) {
        $_SESSION["error"] = "Error";
        header('location:../view_role.php');
        exit;
      }

      $stmt = $conn->prepare("
        SELECT id FROM tbl_groups
        WHERE name = ? AND id != ? AND delete_status = 0
      ");

      $stmt->execute([$assign_name, $id]);
      $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$duplicate) {
        $stmto = $conn->prepare("delete  from tbl_permission_role where group_id='" . $_POST['id'] . "'");
        $stmto->execute();

        $stmt = $conn->prepare("UPDATE tbl_groups set name='$assign_name',description='$description' where id='" . $_POST['id'] . "'");
        $stmt->execute();

        $checkItem = $_POST["checkItem"];
        //print_r($_POST);
        $a = count($checkItem);
        for ($i = 0; $i < $a; $i++) {
          $id = $_POST['id'];

          $sql = "insert into tbl_permission_role(permission_id,group_id)values('$checkItem[$i]','$id')";
          $execute = $conn->query($sql);
        }
        if ($execute == true) {
          $_SESSION['success'] = "Role Updated Succesfully";
          header('location:../view_role.php');
          exit;
        }
      } elseif ($duplicate) {
        $_SESSION['error'] = "Role name already exists";
        header('location:../view_role.php');
        exit;
      } else {
        $_SESSION['error'] = "Unexpected input";
        header('location:../view_role.php');
        exit;
      }
    }

    if (isset($_POST['del_id'])) {
      $group_id = $_POST['del_id'];

      $stmt = $conn->prepare("SELECT id FROM tbl_groups WHERE id = ? AND delete_status = 0");
      $stmt->execute([$group_id]);
      $group = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$group) {
        $_SESSION['error'] = "Error";
        header('location:../view_role.php');
        exit;
      }

      $stmt = $conn->prepare("
        SELECT COUNT(*) AS active_users 
        FROM tbl_admin 
        WHERE role_id = ? AND delete_status = 0
      ");
      $stmt->execute([$group_id]);
      $active = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($active['active_users'] > 0) {
        $_SESSION['error'] = "Cannot delete this role. Some users assigned to it are still active.";
        header('location:../view_role.php');
        exit;
      }

      $stmt = $conn->prepare("UPDATE tbl_groups SET delete_status=1 WHERE id=:id");
      $stmt->bindParam(':id', $_POST['del_id']);
      $stmt->execute();

      $_SESSION['success'] = "Role Deleted Succesfully";
      header('location:../view_role.php');
      exit;
    }
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
} else {

  header("location:../");
}

?>