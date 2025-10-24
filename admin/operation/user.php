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


      if (empty($_POST['password']) || empty($_POST['cpassword'])){
        $_SESSION['error'] = "Password fields must not be empty";
        header('location:../view_user.php');
        exit;
      }

      if ($_POST['password'] != $_POST['cpassword']) {
        $_SESSION['error'] = "Mismatching passwords";
        header('location:../view_user.php');
        exit;
      }


      $passw = hash('sha256', $_POST['password']);

      function createSalt()
      {
        return '2123293dsj2hu2nikhiljdsd';
      }
      $salt = createSalt();
      $password = hash('sha256', $salt . $passw);

      $role = 'admin';
      $stmt = $conn->prepare("INSERT INTO `tbl_admin`(
          `fname`,`lname`,`email`,`role_id`,`role`,`password`,`project`,`address`,
          `contact`,`username`,`gender`,`dob`,`image`,`created_on`,`bank_name`,
          `acc_name`,`acc_no`,`amount`,`total_amount`,`app_code`,`delete_status`,
          `admin_user`,`gstin`
      ) VALUES (
          :fname,:lname,:email,:group_id,:role,:password,:project,:address,
          :contact,:username,:gender,:dob,:image,:created_on,:bank_name,
          :acc_name,:acc_no,:amount,:total_amount,:app_code,:delete_status,
          :admin_user,:gstin
      )");


$fname = htmlspecialchars($_POST['fname']);
$lname = htmlspecialchars($_POST['lname']);
$email = htmlspecialchars($_POST['email']);
$group_id = htmlspecialchars($_POST['group_id']);
$role = htmlspecialchars($role); // Assuming $role is already sanitized or validated
$password = htmlspecialchars($password); // Assuming $password is already sanitized or validated
$username = htmlspecialchars($_POST['fname'] . $_POST['lname']);
$gender = 'Male';
$dob = '';
$image = '';
$created_on = date('Y-m-d');
$bank_name = '';
$acc_name = '';
$acc_no = '';
$amount = 0;
$total_amount = '';
$app_code = 0;
$delete_status = 0;
$admin_user = 0;
$gstin = '';


$stmt->bindParam(':fname', $fname);
$stmt->bindParam(':lname', $lname);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':group_id', $group_id);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':project', $_POST['project']);
$stmt->bindParam(':address', $_POST['address']);
$stmt->bindParam(':contact', $_POST['contact']);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':gender', $gender);
$stmt->bindParam(':dob', $dob);
$stmt->bindParam(':image', $image);
$stmt->bindParam(':created_on', $created_on);
$stmt->bindParam(':bank_name', $bank_name);
$stmt->bindParam(':acc_name', $acc_name);
$stmt->bindParam(':acc_no', $acc_no);
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':total_amount', $total_amount);
$stmt->bindParam(':app_code', $app_code);
$stmt->bindParam(':delete_status', $delete_status);
$stmt->bindParam(':admin_user', $admin_user);
$stmt->bindParam(':gstin', $gstin);
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

      function createSalt()
      {
        return '2123293dsj2hu2nikhiljdsd';
      }

      if (empty($_POST['password']) || empty($_POST['cpassword'])){
        $_SESSION['error'] = "Password fields must not be empty";
        header('location:../view_user.php');
        exit;
      }

      if ($_POST['password'] != $_POST['cpassword']) {
        $_SESSION['error'] = "Mismatching passwords";
        header('location:../view_user.php');
        exit;
      }
      else {
        $passw = hash('sha256', $_POST['password']);
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