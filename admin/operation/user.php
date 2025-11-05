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
      // CSRF token check
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../view_user.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

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

      $password_raw = $_POST['password'];
      $password_confirm = $_POST['cpassword'];

      if (empty($password_raw) || empty($password_confirm)) {
        $_SESSION['error'] = "Password fields must not be empty";
        header('location:../view_user.php');
        exit;
      }

      if ($password_raw !== $password_confirm) {
        $_SESSION['error'] = "Mismatching passwords";
        header('location:../view_user.php');
        exit;
      }

      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $email = $_POST['email'];
      $contact = $_POST['contact'];
      $address = $_POST['address'];

      $errors = [];

      if (!preg_match("/^[a-zA-Z ]+$/", $fname)) {
        $errors[] = 'Invalid First Name: Only letters and spaces allowed';
      } elseif (strlen($fname) > 50) {
        $errors[] = 'Invalid First Name: Must not exceed 50 characters';
      }
      if (!preg_match("/^[a-zA-Z ]+$/", $lname)) {
        $errors[] = 'Invalid Last Name: Only letters and spaces allowed';
      } elseif (strlen($lname) > 500) {
        $errors[] = 'Invalid Last Name: Must not exceed 500 characters';
      }
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid Email Address';
      } elseif (strlen($email) > 30) {
        $errors[] = 'Invalid Email Address: Must not exceed 30 characters';
      }
      if (!preg_match("/^\+?\d{1,50}$/", $contact)) {
        $errors[] = 'Invalid Contact Number: Must contain only digits and optional + at the start (max 50 characters)';
      }
      if (strlen($address) > 500) {
        $errors[] = 'Address must not exceed 500 characters';
      }

      if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('location:../view_user.php');
        exit();
      }

      $group_id = htmlspecialchars($_POST['group_id']);

      $stmt = $conn->prepare("
        SELECT 
            (SELECT COUNT(*) 
            FROM tbl_admin 
            WHERE email = ? AND delete_status = 0) AS email_count,
            (SELECT COUNT(*) 
            FROM tbl_groups 
            WHERE id = ? AND delete_status = 0) AS group_count
      ");

      $stmt->execute([$email, $group_id]);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result['email_count'] > 0) {
        $_SESSION['error'] = "Email already exists";
        header('location:../view_user.php');
        exit;
      }

      if ($result['group_count'] == 0) {
        $_SESSION['error'] = "Error: Invalid group";
        header('location:../view_user.php');
        exit;
      }

      $options = [
        'cost' => 12,
      ];

      $password = password_hash($password_raw, PASSWORD_BCRYPT, $options);

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

      $username = htmlspecialchars($_POST['fname'] . $_POST['lname']);
      $gender = '';
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
      $project = NULL;


      $stmt->bindParam(':fname', $fname);
      $stmt->bindParam(':lname', $lname);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':group_id', $group_id);
      $stmt->bindParam(':role', $role);
      $stmt->bindParam(':password', $password);
      $stmt->bindParam(':project', $project);
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
      // CSRF token check
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../view_user.php');
        exit;
      }

      unset($_SESSION['csrf_token']);

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

      $password_raw = $_POST['password'];
      $password_confirm = $_POST['cpassword'];

      if (empty($password_raw) || empty($password_confirm)) {
        $_SESSION['error'] = "Password fields must not be empty";
        header('location:../view_user.php');
        exit;
      }

      if ($password_raw !== $password_confirm) {
        $_SESSION['error'] = "Mismatching passwords";
        header('location:../view_user.php');
        exit;
      } else {
        $email = $_POST['email'];
        $id = $_POST['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

        $errors = [];

        if (!preg_match("/^[a-zA-Z ]+$/", $fname)) {
          $errors[] = 'Invalid First Name: Only letters and spaces allowed';
        } elseif (strlen($fname) > 50) {
          $errors[] = 'Invalid First Name: Must not exceed 50 characters';
        }
        if (!preg_match("/^[a-zA-Z ]+$/", $lname)) {
          $errors[] = 'Invalid Last Name: Only letters and spaces allowed';
        } elseif (strlen($lname) > 500) {
          $errors[] = 'Invalid Last Name: Must not exceed 500 characters';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors[] = 'Invalid Email Address';
        } elseif (strlen($email) > 30) {
          $errors[] = 'Invalid Email Address: Must not exceed 30 characters';
        }
        if (!preg_match("/^\+?\d{1,50}$/", $contact)) {
          $errors[] = 'Invalid Contact Number: Must contain only digits and optional + at the start (max 50 characters)';
        }
        if (strlen($address) > 500) {
          $errors[] = 'Address must not exceed 500 characters';
        }
        if (!empty($errors)) {
          $_SESSION['error'] = implode('<br>', $errors);
          header('location:../view_user.php');
          exit();
        }

        $group_id = htmlspecialchars($_POST['group_id']);

        $stmt = $conn->prepare("
        SELECT
            (SELECT COUNT(*) 
            FROM tbl_admin 
            WHERE id = ? AND delete_status = 0) AS id_exists,
            (SELECT COUNT(*) 
            FROM tbl_admin 
            WHERE email = ? AND id != ? AND delete_status = 0) AS email_duplicate,
            (SELECT COUNT(*) 
            FROM tbl_groups 
            WHERE id = ? AND delete_status = 0) AS group_exists
        ");

        $stmt->execute([$id, $email, $id, $group_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['id_exists'] == 0) {
          $_SESSION['error'] = "Error: User not found";
          header('location:../view_user.php');
          exit;
        }

        $duplicate = $result['email_duplicate'];

        if (!$duplicate) {
          if ($result['group_exists'] == 0) {
            $_SESSION['error'] = "Error: Group not found";
            header('location:../view_user.php');
            exit;
          }

          $options = [
            'cost' => 12,
          ];

          $password = password_hash($password_raw, PASSWORD_BCRYPT, $options);

          $stmt = $conn->prepare("UPDATE tbl_admin SET email=:email, role_id=:group_id, fname=:fname, lname=:lname, password=:password , project=:project, address=:address, contact=:contact WHERE id=:id");

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
            $_SESSION['success'] = "User Updated Successfully.";
            header('location:../view_user.php');
            exit;
          }
        } elseif ($duplicate) {
          $_SESSION['error'] = "Email already exists";
          header('location:../view_user.php');
          exit;
        } else {
          $_SESSION['error'] = "Unexpected input detected.";
          header('location:../view_user.php');
          exit;
        }
      }
    }

    if (isset($_POST['del_id'])) {
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token";
        header('location:../view_user.php');
        exit;
      }

      unset($_SESSION['csrf_token']);
      $userId = $_POST['del_id'];

      $stmt = $conn->prepare("
            SELECT email FROM tbl_admin
            WHERE id = ? AND delete_status = 0 AND role_id != 0
      ");

      $stmt->execute([$userId]);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$record) {
        $_SESSION['error'] = "Error";
        header('location:../view_user.php');
        exit;
      }

      try {
        $stmt = $conn->prepare("
          UPDATE tbl_admin a
          LEFT JOIN tbl_invoice i ON i.user = a.id
          LEFT JOIN tbl_quot_inv_items qii ON qii.inv_id = i.inv_no
          SET 
              a.delete_status = 1,
              i.delete_status = 1,
              qii.delete_status = 1
          WHERE a.id = ?
        ");

        $stmt->execute([$userId]);


        $_SESSION['success'] = "User deleted successfully";
        header('location:../view_user.php');
        exit;
      } catch (Exception $e) {
        $conn->rollBack();
        $_SESSION['error'] = "Error deleting user: " . $e->getMessage();
        header('location:../view_user.php');
        exit;
      }
    }

  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
} else {

  header("location:../");
}

?>