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
  //print_r($_POST);
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['btn_save'])) {
      $cust_name = $_POST['custname'];
      $cust_mob = $_POST['customer_mobno'];
      $cust_email = $_POST['c_email'];
      $cust_address = $_POST['c_address'];
      $state = (int) $_POST['state'];
      $gstin = $_POST['gstin'];

      $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_states WHERE id = :state_id");
      $stmt->bindParam(':state_id', $state, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->fetchColumn() == 0) {
        $_SESSION['error'] = 'Invalid State: Selected state does not exist.';
        header('location:../view_customer.php');
        exit();
      }

      $stmt2 = $conn->prepare("
      SELECT 
          (SELECT COUNT(*) FROM tbl_customer WHERE cust_mob = :cust_mob) AS mob_exists,
          (SELECT COUNT(*) FROM tbl_customer WHERE cust_email = :cust_email) AS email_exists
      ");
      $stmt2->bindParam(':cust_mob', $cust_mob);
      $stmt2->bindParam(':cust_email', $cust_email);
      $stmt2->execute();

      $result = $stmt2->fetch(PDO::FETCH_ASSOC);

      if ($result['mob_exists'] > 0) {
        $_SESSION['error'] = 'This contact number is already registered.';
        header('location:../view_customer.php');
        exit();
      }

      if ($result['email_exists'] > 0) {
        $_SESSION['error'] = 'This email address is already registered.';
        header('location:../view_customer.php');
        exit();
      }

      $errors = [];

      if (!preg_match("/^[a-zA-Z ]+$/", $cust_name)) {
        $errors[] = 'Invalid customer name: Only letters and spaces allowed';
      } elseif (strlen($cust_name) > 50) {
        $errors[] = 'Invalid customer name: Must not exceed 50 characters';
      }
      if (!filter_var($cust_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid customer email address';
      } elseif (strlen($cust_email) > 30) {
        $errors[] = 'Invalid customer email address: Must not exceed 30 characters';
      }
      if (!preg_match("/^\d{10}$/", $cust_mob)) {
        $errors[] = 'Invalid customer contact number: Must be exactly 10 digits';
      }
      if (strlen($cust_address) > 50) {
        $errors[] = 'Address must not exceed 50 characters';
      }
      if (!preg_match("/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/", $gstin)) {
        $errors[] = 'Invalid GSTIN: Must follow the 15-character GST format (e.g., 27AAECR1234F1Z2)';
      }
      if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('location:../view_customer.php');
        exit();
      }

      $stmt = $conn->prepare("INSERT INTO tbl_customer (cust_name,cust_mob,cust_email,cust_address, state, gstin) VALUES (:cust_name,:cust_mob,:cust_email,:cust_address,:state,:gstin)");
      $stmt->bindParam(':cust_name', $cust_name);
      $stmt->bindParam(':cust_mob', $cust_mob);
      $stmt->bindParam(':cust_email', $cust_email);
      $stmt->bindParam(':cust_address', $cust_address);
      $stmt->bindParam(':state', $state);
      $stmt->bindParam(':gstin', $gstin);
      $stmt->execute();


      $_SESSION['success'] = "Customer Added Succesfully";
      header('location:../view_customer.php');
      exit;

    }


    if (isset($_POST['btn_save1'])) {


      $stmt = $conn->prepare("INSERT INTO tbl_customer (cust_name,cust_mob,cust_email,cust_address, state, gstin) VALUES (:cust_name,:cust_mob,:cust_email,:cust_address,:state,:gstin)");
      $stmt->bindParam(':cust_name', $_POST['custname']);
      $stmt->bindParam(':cust_mob', $_POST['customer_mobno']);

      $stmt->bindParam(':cust_email', $_POST['c_email']);
      $stmt->bindParam(':cust_address', $_POST['c_address']);
      $stmt->bindParam(':state', $_POST['state']);
      $stmt->bindParam(':gstin', $_POST['gstin']);
      $stmt->execute();
      //echo "<script>alert(' Record Successfully Added');</script>";

      $_SESSION['reply'] = "003";
      ?>
      <div class="popup popup--icon -success js_success-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
          <h3 class="popup__content__title">
            Success
            </h1>
            <p>Record Successfully Added</p>
            <p>

              <?php echo "<script>setTimeout(\"location.href = '../estimate.php';\",1500);</script>"; ?>
            </p>
        </div>
      </div>
      </div>

      <?php

    }


    if (isset($_POST['btn_save2'])) {


      $stmt = $conn->prepare("INSERT INTO tbl_customer (cust_name,cust_mob,cust_email,cust_address, state, gstin) VALUES (:cust_name,:cust_mob,:cust_email,:cust_address,:state,:gstin)");
      $stmt->bindParam(':cust_name', $_POST['custname']);
      $stmt->bindParam(':cust_mob', $_POST['customer_mobno']);

      $stmt->bindParam(':cust_email', $_POST['c_email']);
      $stmt->bindParam(':cust_address', $_POST['c_address']);
      $stmt->bindParam(':state', $_POST['state']);
      $stmt->bindParam(':gstin', $_POST['gstin']);
      $stmt->execute();
      //echo "<script>alert(' Record Successfully Added');</script>";

      $_SESSION['reply'] = "003";
      ?>
      <div class="popup popup--icon -success js_success-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
          <h3 class="popup__content__title">
            Success
            </h1>
            <p>Record Successfully Added</p>
            <p>

              <?php echo "<script>setTimeout(\"location.href = '../order.php';\",1500);</script>"; ?>
            </p>
        </div>
      </div>
      </div>

      <?php

    }



    if (isset($_POST['btn_update'])) {
      $cust_id = (int) $_POST['id'];
      $cust_name = $_POST['custname'];
      $cust_mob = $_POST['customer_mobno'];
      $cust_email = $_POST['c_email'];
      $cust_address = $_POST['c_address'];
      $state = (int) $_POST['state'];
      $gstin = $_POST['gstin'];

      $stmt = $conn->prepare("
          SELECT cust_name FROM tbl_customer 
          WHERE cust_id = ? 
      ");

      $stmt->execute([$cust_id]);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$record) {
        $_SESSION['error'] = "Error";
        header('location:../view_customer.php');
        exit;
      }

      // Check if state exists
      $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_states WHERE id = :state_id");
      $stmt->bindParam(':state_id', $state, PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->fetchColumn() == 0) {
        $_SESSION['error'] = 'Invalid State: Selected state does not exist.';
        header('location:../view_customer.php');
        exit();
      }

      // Check if contact number or email already exists (excluding this customer)
      $stmt2 = $conn->prepare("
      SELECT 
          (SELECT COUNT(*) FROM tbl_customer WHERE cust_mob = :cust_mob AND cust_id != :cust_id) AS mob_exists,
          (SELECT COUNT(*) FROM tbl_customer WHERE cust_email = :cust_email AND cust_id != :cust_id) AS email_exists
    ");
      $stmt2->bindParam(':cust_mob', $cust_mob);
      $stmt2->bindParam(':cust_email', $cust_email);
      $stmt2->bindParam(':cust_id', $cust_id, PDO::PARAM_INT);
      $stmt2->execute();

      $result = $stmt2->fetch(PDO::FETCH_ASSOC);

      if ($result['mob_exists'] > 0) {
        $_SESSION['error'] = 'This contact number is already registered to another customer.';
        header('location:../view_customer.php');
        exit();
      }

      if ($result['email_exists'] > 0) {
        $_SESSION['error'] = 'This email address is already registered to another customer.';
        header('location:../view_customer.php');
        exit();
      }

      // Validation rules
      $errors = [];

      if (!preg_match("/^[a-zA-Z ]+$/", $cust_name)) {
        $errors[] = 'Invalid customer name: Only letters and spaces allowed';
      } elseif (strlen($cust_name) > 50) {
        $errors[] = 'Invalid customer name: Must not exceed 50 characters';
      }
      if (!filter_var($cust_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid customer email address';
      } elseif (strlen($cust_email) > 30) {
        $errors[] = 'Invalid customer email address: Must not exceed 30 characters';
      }
      if (!preg_match("/^\d{10}$/", $cust_mob)) {
        $errors[] = 'Invalid customer contact number: Must be exactly 10 digits';
      }
      if (strlen($cust_address) > 50) {
        $errors[] = 'Address must not exceed 50 characters';
      }
      if (!preg_match("/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/", $gstin)) {
        $errors[] = 'Invalid GSTIN: Must follow the 15-character GST format (e.g., 27AAECR1234F1Z2)';
      }

      if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header('location:../view_customer.php');
        exit();
      }

      // Proceed with update
      $stmt = $conn->prepare("
        UPDATE tbl_customer 
        SET cust_name = :cust_name,
            cust_mob = :cust_mob,
            cust_email = :cust_email,
            cust_address = :cust_address,
            state = :state,
            gstin = :gstin
        WHERE cust_id = :cust_id
    ");
      $stmt->bindParam(':cust_name', $cust_name);
      $stmt->bindParam(':cust_mob', $cust_mob);
      $stmt->bindParam(':cust_email', $cust_email);
      $stmt->bindParam(':cust_address', $cust_address);
      $stmt->bindParam(':state', $state);
      $stmt->bindParam(':gstin', $gstin);
      $stmt->bindParam(':cust_id', $cust_id, PDO::PARAM_INT);

      if ($stmt->execute()) {
        $_SESSION['success'] = "Customer Updated Successfully";
        header('location:../view_customer.php');
        exit();
      } else {
        $_SESSION['error'] = "Failed to update customer.";
        header('location:../view_customer.php');
        exit();
      }
    }

    if (isset($_GET['id'])) {
      $stmt = $conn->prepare("DELETE FROM tbl_customer WHERE cust_id = :cust_id");
      // $stmt = $conn->prepare("UPDATE tbl_product SET delete_status=1 WHERE id=:id");
      $stmt->bindParam(':cust_id', $_GET['id']);
      $stmt->execute();

      $_SESSION['success'] = "Customer Deleted Succesfully";
      header('location:../view_customer.php');
      exit;
    }


    if (isset($_POST['del_id'])) {
      $cust_id = $_POST['del_id'];

      $stmt = $conn->prepare("
          SELECT cust_name FROM tbl_customer 
          WHERE cust_id = ? 
      ");

      $stmt->execute([$cust_id]);
      $record = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$record) {
        $_SESSION['error'] = "Error";
        header('location:../view_customer.php');
        exit;
      }

      $stmt2 = $conn->prepare("UPDATE tbl_invoice SET delete_status = 1 WHERE customer_id = :cust_id");
      $stmt2->bindParam(':cust_id', $cust_id);
      $stmt2->execute();

      $stmt = $conn->prepare("DELETE FROM tbl_customer WHERE cust_id = :cust_id");
      $stmt->bindParam(':cust_id', $cust_id);
      $stmt->execute();

      $_SESSION['success'] = "Customer and respective invoices were deleted succesfully";
      header('location:../view_customer.php');
      exit;
    }

  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

} else {

  header("location:../");

}

?>