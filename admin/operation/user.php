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
      $target_dir = "../../assets/uploadImage/Candidate/";
      $website_logo = basename($_FILES["website_image"]["name"]);
      if ($_FILES["website_image"]["tmp_name"] != '') {
        $image = $target_dir . basename($_FILES["website_image"]["name"]);
        if (move_uploaded_file($_FILES["website_image"]["tmp_name"], $image)) {

          @unlink("../../assets/uploadImage/Candidate/" . $_POST['old_website_image']);
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      } else {
        $website_logo = $_POST['old_website_image'];
      }


      $passw = hash('sha256', $_POST['password']);

      function createSalt()
      {
        return '2123293dsj2hu2nikhiljdsd';
      }
      $salt = createSalt();
      $password = hash('sha256', $salt . $passw);

      $role = 'admin';
      $stmt = $conn->prepare("INSERT INTO `tbl_admin`( `fname`,`lname`,`email`,`role_id`, `role`,`password`,`project`,`address`,`contact`) VALUES (:fname,:lname,:email,:group_id,:role,:password,:project,:address,:contact)");

$fname = htmlspecialchars($_POST['fname']);
$lname = htmlspecialchars($_POST['lname']);
$email = htmlspecialchars($_POST['email']);
$group_id = htmlspecialchars($_POST['group_id']);
$role = htmlspecialchars($role); // Assuming $role is already sanitized or validated
$password = htmlspecialchars($password); // Assuming $password is already sanitized or validated

$stmt->bindParam(':fname', $fname);
$stmt->bindParam(':lname', $lname);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':group_id', $group_id);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':project', $_POST['project']);
$stmt->bindParam(':address', $_POST['address']);
$stmt->bindParam(':contact', $_POST['contact']);
$stmt->execute();


     $_SESSION['success'] = "User Added Succesfully";
      header('location:../view_user.php');
      exit;
    }

    if (isset($_POST['btn_edit'])) {
      //$id=$_GET['id'];
      //echo "string";
      $target_dir = "../../assets/uploadImage/Candidate/";
      $website_logo = basename($_FILES["website_image"]["name"]);
      if ($_FILES["website_image"]["tmp_name"] != '') {
        $image = $target_dir . basename($_FILES["website_image"]["name"]);
        if (move_uploaded_file($_FILES["website_image"]["tmp_name"], $image)) {

          @unlink("../../assets/uploadImage/Candidate/" . $_POST['old_website_image']);
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
      } else {
        $website_logo = $_POST['old_website_image'];
      }


      if ($_POST['old_pass'] == $_POST['password']) {
        $password = $_POST['password'];
      } else {
        $passw = hash('sha256', $_POST['password']);

        function createSalt()
        {
          return '2123293dsj2hu2nikhiljdsd';
        }
        $salt = createSalt();
        $password = hash('sha256', $salt . $passw);
      }


      $stmt = $conn->prepare("UPDATE tbl_admin SET email=:email, role_id=:group_id, fname=:fname, lname=:lname, password=:password , project=:project, address=:address, contact=:contact WHERE id=:id");

      $fname = htmlspecialchars($_POST['fname']);
      $lname = htmlspecialchars($_POST['lname']);
      $email = htmlspecialchars($_POST['email']);
      $group_id = htmlspecialchars($_POST['group_id']);
      $password = htmlspecialchars($password); // Assuming $password is already sanitized or validated
      $id = htmlspecialchars($_POST['id']); // Assuming $_POST['id'] is already sanitized or validated
      
      $stmt->bindParam(':fname', $fname);
      $stmt->bindParam(':lname', $lname);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':group_id', $group_id);
      $stmt->bindParam(':password', $password);
        $stmt->bindParam(':project', $_POST['project']);
        $stmt->bindParam(':address', $_POST['address']);
        $stmt->bindParam(':contact', $_POST['contact']);
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      

      $execute = $stmt->execute();
      if ($execute == true) {
       $_SESSION['success'] = "User Updated Succesfully";
      header('location:../view_user.php');
      exit;
}
    }

    if (isset($_POST['del_id'])) {
      //$stmt = $conn->prepare("DELETE FROM customers WHERE id = :id");
      $stmt = $conn->prepare("UPDATE tbl_admin SET delete_status=1 WHERE id=:id");
      $stmt->bindParam(':id', $_POST['del_id']);
      $stmt->execute();

      $_SESSION['success'] = "User Deleted Succesfully";
      header('location:../view_user.php');
      exit;

}

  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
} else {

  header("location:../");
}

?>