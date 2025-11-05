<?php
//error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token']
?>

<?php

$stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id='" . $_SESSION['id'] . "'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<?php
if (isset($_POST['update'])) {
  // CSRF token check
  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error'] = "Invalid CSRF token";
    header('Location: profile.php');
    exit;
  }

  unset($_SESSION['csrf_token']);


  $email = $_POST['email'];
  $id = $_SESSION['id'];

  $stmt = $conn->prepare("
        SELECT email FROM tbl_admin
        WHERE id = ? and delete_status = 0
    ");

  $stmt->execute([$id]);
  $record = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$record) {
    $_SESSION['error'] = "Error";
    header('Location: profile.php');
    exit;
  }

  $stmt = $conn->prepare("
        SELECT id FROM tbl_admin
        WHERE email = ? AND id != ? AND delete_status = 0
      ");
  $stmt->execute([$email, $id]);
  $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$duplicate) {
    $target_dir = "../assets/uploadImage/Profile/";
    $max_file_size = 10 * 1024 * 1024; // 10 MB
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $allowed_mime_types = ['image/jpeg', 'image/png'];

    $file_tmp = $_FILES["website_image"]["tmp_name"];
    $file_name = $_FILES["website_image"]["name"];
    $file_size = $_FILES["website_image"]["size"];

    $website_logo = $_POST['old_website_image'];

    $errors = [];
    $valid_file = true;

    // --- FILE VALIDATION ---
    if ($file_tmp != '') {
      // 1. Check size
      if ($file_size <= 0 || $file_size > $max_file_size) {
        $errors[] = 'File size must be ≤ 10MB.';
        $valid_file = false;
      }

      // 2. Check extension
      $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
      if (!in_array($ext, $allowed_extensions)) {
        $errors[] = 'Invalid file type, jpg or png only.';
        $valid_file = false;
      }

      // 3. Check MIME type
      if ($valid_file) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file_tmp);
        finfo_close($finfo);
        if (!in_array($mime_type, $allowed_mime_types)) {
          $errors[] = 'Invalid file type, jpg or png only.';
          $valid_file = false;
        }
      }

      // 4. Check magic number
      if ($valid_file) {
        $fp = fopen($file_tmp, 'rb');
        $bytes = fread($fp, 8);
        fclose($fp);
        $hex = bin2hex($bytes);

        if (($ext === 'jpg' || $ext === 'jpeg') && substr($hex, 0, 6) !== 'ffd8ff') {
          $errors[] = 'Invalid file type, jpg or png only.';
          $valid_file = false;
        } elseif ($ext === 'png' && substr($hex, 0, 16) !== '89504e470d0a1a0a') {
          $errors[] = 'Invalid file type, jpg or png only.';
          $valid_file = false;
        }
      }

      // 5. Move file if valid
      if ($valid_file) {
        $new_name = bin2hex(random_bytes(16)) . '.' . $ext;
        $destination = $target_dir . $new_name;
        if (move_uploaded_file($file_tmp, $destination)) {
          if (!empty($_POST['old_website_image'])) {
            @unlink($target_dir . $_POST['old_website_image']);
          }
          $website_logo = $new_name;
        } else {
          $errors[] = 'Sorry, there was an error uploading your file.';
          $valid_file = false;
        }
      }
    }

    // --- INPUT VALIDATION ---
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $dob = !empty($_POST['dob']) ? $_POST['dob'] : '0000-00-00';

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
    if (!preg_match("/^[a-zA-Z0-9_.]+$/", $username)) {
      $errors[] = 'Username can only contain letters, numbers, underscore, and dot';
    }
    if (strlen($username) > 500) {
      $errors[] = 'Username must not exceed 500 characters';
    }
    if (!preg_match("/^(Male|Female)$/i", $gender)) {
      $errors[] = 'Invalid Gender: Must be Male or Female';
    }
    // --- HANDLE ERRORS OR EXECUTE SQL ---
    if (!empty($errors)) {
      $_SESSION['error'] = implode('<br>', $errors);
      header('Location: profile.php');
      exit();
    } else {
      $sql = "UPDATE tbl_admin 
                  SET fname = :fname,
                      lname = :lname,
                      email = :email,
                      username = :username,
                      gender = :gender,
                      dob = :dob,
                      contact = :contact,
                      address = :address,
                      image = :website_logo
                  WHERE id = :id";

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':fname', $fname);
      $stmt->bindParam(':lname', $lname);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':gender', $gender);
      $stmt->bindParam(':dob', $dob);
      $stmt->bindParam(':contact', $contact);
      $stmt->bindParam(':address', $address);
      $stmt->bindParam(':website_logo', $website_logo);
      $stmt->bindParam(':id', $id);

      if ($stmt->execute()) {
        $_SESSION['success'] = 'Profile Successfully Updated';
      } else {
        $_SESSION['error'] = 'Something went wrong while updating your profile.';
      }
      header('Location: profile.php');
      exit();
    }
  } elseif ($duplicate) {
    $_SESSION['error'] = "Email already exists";
    header('Location: profile.php');
    exit;
  } else {
    $_SESSION['error'] = "Unexpected input detected.";
    header('Location: profile.php');
    exit;
  }
}
?>



<?php include('include/head.php'); ?>
<link rel="stylesheet" href="operation/popup_style.css">

<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>
<div class="dashboard-wrapper">
  <div class="container-fluid  dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title">Profile </h2>
          <p class="pageheader-text">Profile</p>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <!--  <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Forms</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Form Validations</li>
                                  -->
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->

    <div class="row">
      <!-- ============================================================== -->
      <!-- validation form -->
      <!-- ============================================================== -->
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <h5 class="card-header">Profile</h5>
          <div class="card-body">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" id="add_brand">
              <div class="row">
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                  <div class="text-center">
                    <img
                      src="../assets/uploadImage/Profile/<?php echo htmlspecialchars($result['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                      alt="User Avatar" class="rounded-circle user-avatar-xxl">
                  </div>
                </div>
                <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                  <div class="user-avatar-info">
                    <div class="m-b-20">
                      <div class="user-avatar-name">

                        <h2 class="mb-1">
                          <?php echo htmlspecialchars($result['fname'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                          <?php echo htmlspecialchars($result['lname'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                        </h2>

                      </div>
                    </div>
                    <!--  <div class="float-right"><a href="#" class="user-avatar-email text-secondary">www.henrybarbara.com</a></div> -->
                    <div class="user-avatar-address">
                      <div class="mt-3">
                        <!-- <image class="profile-img" src="../assets/uploadImage/Profile/<?= $result['image'] ?>" style="height:35%;width:25%;">
                 --> <input type="hidden"
                          value="<?php echo htmlspecialchars($result['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                          name="old_website_image">
                        <input type="file" class="form-control" name="website_image" accept="image/jpeg/png">

                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">

                      <label for="validationCustom03">First Name<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="fname"
                        value="<?php echo htmlspecialchars($result['fname'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                      <div class="invalid-feedback">
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                      <label for="validationCustom04">Last Name<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="lname"
                        value="<?php echo htmlspecialchars($result['lname'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                      <div class="invalid-feedback">
                      </div>
                    </div>




                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                      <label for="validationCustom02">Email<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="email"
                        value="<?php echo htmlspecialchars($result['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                      <div class="valid-feedback">
                      </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                      <label for="validationCustom01">Gender<span class="text-danger">*</span></label>
                      <select type="text" class="form-control" placeholder="" name="gender" required=""
                        value="<?php echo htmlspecialchars($result['dob'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">

                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                      <div class="valid-feedback">
                      </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                      <label for="validationCustom02">Mob No<span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="contact"
                        value="<?php echo htmlspecialchars($result['contact'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                      <div class="valid-feedback">
                      </div>
                    </div>


                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                      <label for="validationCustomUsername">Username<span class="text-danger">*</span></label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroupPrepend">@</span>
                        </div>
                        <input type="text" class="form-control " name="username"
                          value="<?php echo htmlspecialchars($result['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                          required>
                        <div class="invalid-feedback">
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                      <label for="validationCustom02">Address<span class="text-danger">*</span></label>
                      <textarea class="form-control" name="address"
                        required><?php echo htmlspecialchars($result['address'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>

                      <div class="valid-feedback">
                      </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                      <!-- <label for="validationCustom02">Upload Profile</label>
                                                <image class="profile-img" src="../assets/uploadImage/Profile/<?= $result['image'] ?>" style="height:35%;width:25%;">
                  <input type="hidden" value="<?= $result['image'] ?>" name="old_website_image">
                          <input type="file" class="form-control" name="website_image" accept="image/jpeg/png" > -->
                      <div class="valid-feedback">
                      </div>
                    </div>


                  </div>
                  <br>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                  <center>

                    <button class="btn btn-primary" type="submit" name="update" onclick="addBrand()">Update </button>
                  </center>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end validation form -->
      <!-- ============================================================== -->
    </div>



    <!-- ============================================================== -->
    <!-- end navbar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- left sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- end left sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
  </div>

  <?php include('include/footer.php'); ?>
</div>
<!-- ============================================================== -->
<!-- end wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end main wrapper  -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
<!-- jquery 3.3.1 -->
<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<!-- bootstap bundle js -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<!-- slimscroll js -->
<script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<!-- main js -->
<script src="assets/libs/js/main-js.js"></script>
<script src="assets/libs/js/jquery.js"></script>
<!-- chart chartist js -->
<script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
<!-- sparkline js -->
<script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
<!-- morris js -->
<script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
<script src="assets/vendor/charts/morris-bundle/morris.js"></script>
<!-- chart c3 js -->
<script src="assets/vendor/charts/c3charts/c3.min.js"></script>
<script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
<script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
<script src="assets/libs/js/dashboard-ecommerce.js"></script>


<style>
  .error {
    color: red !important;

  }
</style>
<script src="../assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"
  integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- ... (your existing HTML code) ... -->

<script>
  function addBrand() {
    jQuery.validator.addMethod("alphanumeric", function (value, element) {
      // Check if the value is empty
      if (value.trim() === "") {
        return false;
      }
      // Check if the value contains at least one alphabet character
      if (!/[a-zA-Z]/.test(value)) {
        return false;
      }
      // Check if the value contains only alphanumeric characters, spaces, and allowed special characters
      return /^[a-zA-Z0-9\s!@#$%^&*()_-]+$/.test(value);
    }, "Please enter alphanumeric characters with at least one alphabet character.");

    jQuery.validator.addMethod("lettersonly", function (value, element) {
      // Check if the value is empty
      if (value.trim() === "") {
        return false;
      }
      return /^[a-zA-Z\s]*$/.test(value);
    }, "Please enter alphabet characters only");

    jQuery.validator.addMethod("noSpacesOnly", function (value, element) {
      // Check if the input contains only spaces
      return value.trim() !== '';
    }, "Please enter a non-empty value");

    $('#add_brand').validate({
      rules: {
        fname: {
          required: true

        },
        lname: {
          required: true,
          alphanumeric: true,
          noSpacesOnly: true
        },
        email: {
          required: true,
          noSpacesOnly: true


        },
        contact: {
          required: true,
          digits: true,
          minlength: 10,
          maxlength: 10
        },
        username: {
          required: true
        },
        contact: {
          required: true
        },
        address: {
          required: true
        }
      },
      messages: {
        fname: {
          required: "Please enter a fname.",
          pattern: "Only alphanumeric characters are allowed."
        },
        lname: {
          required: "Please enter status."
        },
        email: {
          required: "Please enter status."
        },
        contact: {
          required: "Please enter contact."
        },
        username: {
          required: "Please enter username."
        },
        address: {
          required: "Please enter address."
        }


      },
    });
  };
</script>
</body>

</html>