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
    // print_r($_POST); exit;
    if (isset($_POST['btn_save'])) {
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../view_role.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

      extract($_POST);
      $id = $_POST['id'];

      $stmt = $conn->prepare("
          SELECT id FROM tbl_groups
          WHERE name = ? AND id != ? AND delete_status = 0
      ");

      $stmt->execute([$assign_name, $id]);
      $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$duplicate) {
        $checkItem = $_POST["checkItem"];

        if (!is_array($checkItem) || empty($checkItem)) {
          $_SESSION['error'] = "No permissions selected.";
          header('location:../view_role.php');
          exit;
        }

        foreach ($checkItem as $value) {
          if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $_SESSION['error'] = "Invalid permission ID detected.";
            header('location:../view_role.php');
            exit;
          }
        }


        $delete_status = 0;
        $stmt = $conn->prepare("
        INSERT INTO tbl_groups (name, description, delete_status) 
        VALUES (:name, :description, :delete_status)
        ");
        $stmt->bindParam(':name', $assign_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':delete_status', $delete_status, PDO::PARAM_INT);
        $stmt->execute();
        $last_id = $conn->lastInsertId();
        $id = $last_id;


        //print_r($_POST);exit;
        $a = count($checkItem);
        $stmt = $conn->prepare("
        INSERT INTO tbl_permission_role (permission_id, group_id) 
        VALUES (:permission_id, :group_id)
        ");

        for ($i = 0; $i < $a; $i++) {
          $stmt->bindParam(':permission_id', $checkItem[$i], PDO::PARAM_INT);
          $stmt->bindParam(':group_id', $id, PDO::PARAM_INT);
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
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../view_role.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

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
        $checkItem = $_POST["checkItem"];

        if (!is_array($checkItem) || empty($checkItem)) {
          $_SESSION['error'] = "No permissions selected.";
          header('location:../view_role.php');
          exit;
        }

        foreach ($checkItem as $value) {
          if (!filter_var($value, FILTER_VALIDATE_INT)) {
            $_SESSION['error'] = "Invalid permission ID detected.";
            header('location:../view_role.php');
            exit;
          }
        }

        $id = $_POST['id'];

        $stmto = $conn->prepare("
        DELETE FROM tbl_permission_role 
        WHERE group_id = :group_id
        ");
        $stmto->bindParam(':group_id', $id, PDO::PARAM_INT);
        $stmto->execute();


        $stmt = $conn->prepare("
        UPDATE tbl_groups 
        SET name = :name, description = :description 
        WHERE id = :id AND delete_status = 0
        ");
        $stmt->bindParam(':name', $assign_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Insert new permissions using count loop
        $stmtInsert = $conn->prepare("
        INSERT INTO tbl_permission_role (permission_id, group_id) 
        VALUES (:permission_id, :group_id)
        ");

        $a = count($checkItem);
        for ($i = 0; $i < $a; $i++) {
          $stmtInsert->bindParam(':permission_id', $checkItem[$i], PDO::PARAM_INT);
          $stmtInsert->bindParam(':group_id', $id, PDO::PARAM_INT);
          $stmtInsert->execute();
        }

      
        $_SESSION['success'] = "Role Updated Succesfully";
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

    if (isset($_POST['del_id'])) {
      // CSRF token check
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../view_role.php');
        exit;
      }

      unset($_SESSION['csrf_token']);


      $group_id = $_POST['del_id'];

      $stmt = $conn->prepare("
        SELECT g.id, COUNT(a.id) AS active_users
        FROM tbl_groups g
        LEFT JOIN tbl_admin a ON a.role_id = g.id AND a.delete_status = 0
        WHERE g.id = ? AND g.delete_status = 0
        GROUP BY g.id
      ");
      $stmt->execute([$group_id]);
      $group = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$group) {
        $_SESSION['error'] = "Error: Role not found";
        header('location:../view_role.php');
        exit;
      }

      if ($group['active_users'] > 0) {
        $_SESSION['error'] = "Cannot delete this role. Some users assigned to it are still active.";
        header('location:../view_role.php');
        exit;
      }

      $stmt = $conn->prepare("UPDATE tbl_groups SET delete_status = 1 WHERE id = ?");
      $stmt->execute([$group_id]);

      $_SESSION['success'] = "Role Deleted Successfully";
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