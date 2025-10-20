<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>
<?php


$stmt = $conn->prepare("SELECT * FROM tbl_tax WHERE id='" . $_POST['id'] . "'");
$stmt->execute();
$product_group = $stmt->fetch(PDO::FETCH_ASSOC);


?>


<?php include('include/head.php'); ?>
<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <!-- <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Candidate </h2>
                            <p class="pageheader-text">Candidate</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Forms</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Form Validations</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                 --><!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- validation form -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Edit Tax</h5>
                    <div class="card-body">
                        <form class="form-horizontal row" action="operation/tax.php" method="post" enctype="multipart/form-data" id="add_brand">
                            <div class="col-12 col-md-6">
                                <label class="col-form-label text-sm-right">Name<span class="text-danger">*</span></label>
                               
                                    <input type="hidden" class="form-control " name="id" value="<?= $product_group['id']; ?>">


                                    <input type="text" required="" placeholder="Product Group Name" class="form-control" value="<?= $product_group['name']; ?> " name="name" required>
                               
                            </div>
                            
                            
                            
                                <div class="col-12 col-md-6">
                                <label class="col-form-label text-sm-right">Percentage<span class="text-danger">*</span></label>
                              
                                 


                                    <input type="text" required="" placeholder="Percentage" class="form-control" value="<?= $product_group['percentage']; ?> " name="percentage" required>
                               
                            </div>
                            
                            
                         




                            <br>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                <button class="btn btn-primary" type="submit" name="btn_edit" onclick="addBrand()">Submit</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end validation form -->
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

<style>
    .error {
        color: red !important;

    }
</style>
<script src="../assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- ... (your existing HTML code) ... -->

<script>
    function addBrand() {
        jQuery.validator.addMethod("alphanumeric", function(value, element) {
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

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            // Check if the value is empty
            if (value.trim() === "") {
                return false;
            }
            return /^[a-zA-Z\s]*$/.test(value);
        }, "Please enter alphabet characters only");

        jQuery.validator.addMethod("noSpacesOnly", function(value, element) {
            // Check if the input contains only spaces
            return value.trim() !== '';
        }, "Please enter a non-empty value");

        $('#add_brand').validate({
            rules: {
                name: {
                    required: true,
                    alphanumeric: true,
                    noSpacesOnly: true
                },
                status: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter a name.",
                    pattern: "Only alphanumeric characters are allowed."
                },
                status: {
                    required: "Please enter status."
                }
            },
        });
    };
</script>
</body>

</html>