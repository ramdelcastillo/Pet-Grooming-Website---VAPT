<link rel="stylesheet" href="popup_style.css">


<?php
error_reporting(0);
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

  require_once('../../assets/constants/config.php');

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// print_r($_POST); exit;
    if (isset($_POST['btn_save'])) {
      extract($_POST);

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

    }
    if (isset($_POST['btn_edit'])) {
        
        // print_r($_POST);exit;
      //$id=$_GET['id'];
      //echo "string";
      extract($_POST);
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
  }

    if (isset($_POST['del_id'])) {
      //$stmt = $conn->prepare("DELETE FROM customers WHERE id = :id");
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