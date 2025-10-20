<?php
//error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>

<?php

if (isset($_POST["btn_web"])) {
    //extract($_POST);
    // print_r($_POST);exit;
    $target_dir = "../assets/uploadImage/Logo/";
    $website_logo = basename($_FILES["website_image"]["name"]);
    if ($_FILES["website_image"]["tmp_name"] != '') {
        $image = $target_dir . basename($_FILES["website_image"]["name"]);
        if (move_uploaded_file($_FILES["website_image"]["tmp_name"], $image)) {

            @unlink("../assets/uploadImage/Logo/" . $_POST['old_website_image']);
        } else {
            //echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $website_logo = $_POST['old_website_image'];
    }

    $login_logo = basename($_FILES["login_image"]["name"]);
    if ($_FILES["login_image"]["tmp_name"] != '') {
        $image = $target_dir . basename($_FILES["login_image"]["name"]);
        if (move_uploaded_file($_FILES["login_image"]["tmp_name"], $image)) {

            @unlink("../assets/uploadImage/Logo/" . $_POST['old_login_image']);
        } else {
            //echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $login_logo = $_POST['old_login_image'];
    }


    $sign = basename($_FILES["sign"]["name"]);
    if ($_FILES["sign"]["tmp_name"] != '') {
        $image = $target_dir . basename($_FILES["sign"]["name"]);
        if (move_uploaded_file($_FILES["sign"]["tmp_name"], $image)) {

            @unlink("../assets/uploadImage/Logo/" . $_POST['old_sign']);
        } else {
            //echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $sign = $_POST['old_sign'];
    }
    
    
        $favicon = basename($_FILES["favicon"]["name"]);
    if ($_FILES["favicon"]["tmp_name"] != '') {
        $image12 = $target_dir . basename($_FILES["favicon"]["name"]);
        if (move_uploaded_file($_FILES["favicon"]["tmp_name"], $image12)) {

            @unlink("../assets/uploadImage/Logo/" . $_POST['old_favicon']);
        } else {
            //echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $favicon = $_POST['old_favicon'];
    }


//  $target_dir = "../assets/uploadImage/Logo/";
    $qr = basename($_FILES["qr"]["name"]);
    if ($_FILES["qr"]["tmp_name"] != '') {
        $image = $target_dir . basename($_FILES["qr"]["name"]);
        if (move_uploaded_file($_FILES["qr"]["tmp_name"], $image)) {

            @unlink("../assets/uploadImage/Logo/" . $_POST['old_qr']);
        } else {
            //echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $qr = $_POST['old_qr'];
    }

    /*$q1="UPDATE `manage_website` SET `title`='$title',`short_title`='$short_title',`logo`='$website_logo',`footer`='$footer' ,`currency_code`= '$currency_code',`currency_symbol`= '$currency_symbol',`login_logo`='$login_logo',`invoice_logo`='$invoice_logo' , `background_login_image` = '$background_login_image'";
   */
    $sql = "UPDATE tbl_manage_website SET title=:title,logo=:website_logo,footer=:footer,currency_symbol=:currency_symbol,deduct=:deduct,login_logo=:login_logo,term=:term,sign=:sign,favicon=:favicon, qr=:qr";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', htmlspecialchars($_POST['title']));
    $stmt->bindParam(':website_logo', htmlspecialchars($website_logo));
    $stmt->bindParam(':footer', htmlspecialchars($_POST['footer']));
    $stmt->bindParam(':currency_symbol', htmlspecialchars($_POST['currency_symbol']));
    $stmt->bindParam(':deduct', htmlspecialchars($_POST['deduct']));
    $stmt->bindParam(':login_logo', htmlspecialchars($login_logo));
    $stmt->bindParam(':term', htmlspecialchars($_POST['term']));
    $stmt->bindParam(':sign', htmlspecialchars($sign));
        $stmt->bindParam(':favicon', htmlspecialchars($favicon));
           $stmt->bindParam(':qr', htmlspecialchars($qr));


    $execute = $stmt->execute();


    if ($execute === TRUE) {
        //echo "<script>alert(' Record Successfully Updated');</script>";


        $_SESSION['success'] = 'Record Successfully Updated';
?>
        <!--<div class="popup popup--icon -success js_success-popup popup--visible">-->
        <!--    <div class="popup__background"></div>-->
        <!--    <div class="popup__content">-->
        <!--        <h3 class="popup__content__title">-->
        <!--            Success-->
        <!--            </h1>-->
        <!--            <p>Record Successfully Updated</p>-->
        <!--            <p>-->

        <!--                <//?php echo "<script>setTimeout(\"location.href = 'manage_website.php';\",1500);</script>"; ?>-->
        <!--            </p>-->
        <!--    </div>-->
        <!--</div>-->
        <!--</div>-->

    <?php

    } else {

        //$_SESSION['error']='Something Went Wrong';
    }
    ?>
    <script>
        //window.location = "sms_config.php";
    </script>
<?php
}

?>




<?php
$sql = "select * from tbl_manage_website";
$statement = $conn->prepare($sql);
$statement->execute();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

    //print_r($row);
    extract($row);
    $title = $row['title'];
    $footer = $row['footer'];
    $currency_code = $row['currency_code'];
    $currency_symbol = $row['currency_symbol'];
    $website_logo = $row['logo'];
    $login_logo = $row['login_logo'];
    $invoice_logo = $row['invoice_logo'];
    $deduct = $row['deduct'];
    $term = $row['term'];
    // print_r($term);exit;
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
                    <h2 class="pageheader-title">Manage Website </h2>
                    <p class="pageheader-text">Manage Website</p>
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
            <!-- valifation types -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Manage Website </h5>
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data">

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Do you want to deduct the<br> stock after every order ?</label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <select class="form-control" name="deduct">
                                        <option value="0" <?php echo ($deduct == '0') ? 'selected' : ''; ?>>No</option>
                                        <option value="1" <?php echo ($deduct == '1') ? 'selected' : ''; ?>>Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Title<span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" placeholder="Title" class="form-control" value="<?php echo $title; ?>" name="title" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Currency Symbol<span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text" value="<?php echo $currency_symbol; ?>" name="currency_symbol" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Sidebar Logo<span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <?php
                                    // Read the image file and encode it to Base64
                                    $imagePath1 = "../assets/uploadImage/Logo/" . $login_logo; // Path to your image file
                                    $imageData1 = file_get_contents($imagePath1);
                                    $base64Image1 = base64_encode($imageData1);
                                    ?>
                                    <image class="profile-img" src="data:image/jpeg;base64,<?php echo $base64Image1; ?>" style="height:35%;width:35%;">
                                        <input type="hidden" value="<?= $login_logo ?>" name="old_login_image">
                                        <input type="file" class="form-control" name="login_image">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Login Page Logo<span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <?php
                                    // Read the image file and encode it to Base64
                                    $imagePath2 = "../assets/uploadImage/Logo/" . $website_logo; // Path to your image file
                                    $imageData2 = file_get_contents($imagePath2);
                                    $base64Image2 = base64_encode($imageData2);
                                    ?>
                                    <image class="profile-img" src="data:image/jpeg;base64,<?php echo $base64Image2; ?>" style="height:35%;width:25%;">
                                        <input type="hidden" value="<?= $website_logo ?>" name="old_website_image">
                                        <input type="file" class="form-control" name="website_image">
                                </div>
                            </div>
                            
                            
                            
                            
                             <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Favicon<span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <?php
                                    // Read the image file and encode it to Base64
                                    $imagePath2 = "../assets/uploadImage/Logo/" . $favicon; // Path to your image file
                                    $imageData2 = file_get_contents($imagePath2);
                                    $base64Image2 = base64_encode($imageData2);
                                    ?>
                                    <image class="profile-img" src="data:image/jpeg;base64,<?php echo $base64Image2; ?>" style="height:35%;width:25%;">
                                        <input type="hidden" value="<?= $favicon ?>" name="old_favicon">
                                        <input type="file" class="form-control" name="favicon">
                                </div>
                            </div>


  <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Qr<span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <?php
                                    // Read the image file and encode it to Base64
                                    $imagePath3 = "../assets/uploadImage/Logo/" . $qr; // Path to your image file
                                    $imageData3 = file_get_contents($imagePath3);
                                    $base64Image3 = base64_encode($imageData3);
                                    ?>
                                    <image class="profile-img" src="data:image/jpeg;base64,<?php echo $base64Image3; ?>" style="height:35%;width:25%;">
                                        <input type="hidden" value="<?= $qr; ?>" name="old_qr">
                                        <input type="file" class="form-control" name="qr">
                                </div>
                            </div>




                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Footer<span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input type="text"  data-parsley-minlength="6" placeholder="Footer ." class="form-control" value="<?php echo $footer; ?>" name="footer">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Terms And Condition<br> For Receipt<span class="text-danger">*</span>
                                </label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <textarea  class="form-control" data-parsley-minlength="6" placeholder="Terms ." id="ckeditor"  name="term"><?php echo $term;?></textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right">Admin Signature<span class="text-danger">*</span></label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <?php
                                    // Read the image file and encode it to Base64
                                    $imagePath2 = "../assets/uploadImage/Logo/" . $sign; // Path to your image file
                                    $imageData2 = file_get_contents($imagePath2);
                                    $base64Image2 = base64_encode($imageData2);
                                    ?>
                                    <image class="profile-img" src="data:image/jpeg;base64,<?php echo $base64Image2; ?>" style="height:35%;width:25%;">
                                        <input type="hidden" value="<?= $sign ?>" name="old_sign">
                                        <input type="file" class="form-control" name="sign">
                                </div>
                            </div>




                            <div class="form-group row text-right">
                                <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                    <button  class="btn btn-space btn-primary " type="submit" name="btn_web">Update</button>
                                    <button class="btn btn-space btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end valifation types -->
            <!-- ============================================================== -->
        </div>

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

<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>


<script>
    ClassicEditor
        .create(document.querySelector('#ckeditor'))
        .catch(error => {
            console.error(error);
        });
</script>
</body>

</html>   