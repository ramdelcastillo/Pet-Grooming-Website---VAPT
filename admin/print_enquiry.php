<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>

<?php


$stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id='" . $_SESSION['id'] . "'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<?php
$sql = "SELECT * FROM tbl_invoice_enquiry where  id='" . $_POST['id'] . "'";


$statement = $conn->prepare($sql);
$statement->execute();
$invoice = $statement->fetch(PDO::FETCH_ASSOC);

// print_r($invoice);
// exit;

$sql = "SELECT * FROM tbl_manage_website";
$statement = $conn->prepare($sql);
$statement->execute();
$web = $statement->fetch(PDO::FETCH_ASSOC);
?>


<?php include('include/head.php'); ?>

<?php include('include/header.php'); ?>

<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content" style="background-color: #ffffff;">
            <!-- ============================================================== -->
            <!-- pageheader  -->
            <!-- ============================================================== -->
            <!--<div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title"> Product Invoice </h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">E-coommerce</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">E-Commerce Product Invoice</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    --><!-- ============================================================== -->
            <!-- end pageheader  -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header p-4">
                            <!--                                     <a class="pt-2 d-inline-block" href="index.html">Concept</a>
-->
                            <div class="float-left">
                                <img src="../assets/uploadImage/Logo/<?php echo $web['logo']; ?>" class="img-responsive" style="width: 300px;">
                            </div>
                            <div class="mr-5 text-center">
                                <h3>Invoice</h3>
                            </div>
                            <div class="float-right">
                                <h3 class="mb-0">Invoice #<?= $invoice['inv_no']; ?></h3>
                                Date: <?= $invoice['build_date']; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <h5 class="mb-3">From:</h5>
                                    <h3 class="text-dark mb-1"><?= $result['fname']; ?>&nbsp;<?= $result['lname']; ?></h3>

                                    <div><?= $result['address'] ?></div>
                                    <div>Email: <?= $result['email'] ?></div>
                                    <div>Phone: <?= $result['contact'] ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <h5 class="mb-3">To:</h5>
                                    <h3 class="text-dark mb-1"><?= $invoice['customer_id']; ?></h3>
                                    <div><?= $invoice['c_address']; ?></div>
                                    <div>Email: <?= $invoice['c_email']; ?></div>
                                    <div>Phone: <?= $invoice['customer_no']; ?></div>
                                </div>
                            </div>

                            <label>Products</label>
                            <div class="table-responsive-sm">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>Item</th>
                                            <th>Description</th>
                                            <th class="right">Unit Cost</th>
                                            <th class="center">Qty</th>
                                            <th class="right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql2 = "SELECT * FROM tbl_quot_inv_items_enquiry where inv_id='" . $_POST['id'] . "'";


                                        $statement2 = $conn->prepare($sql2);
                                        $statement2->execute();
                                        while ($row2 = $statement2->fetch(PDO::FETCH_ASSOC)) {

                                            $sql1 = "SELECT * FROM tbl_product where id='" . $row2['product_id'] . "'";


                                            $statement1 = $conn->prepare($sql1);
                                            $statement1->execute();
                                            $row1 = $statement1->fetch(PDO::FETCH_ASSOC);


                                            $no += 1;
                                        ?>
                                            <tr>
                                                <td class="center"><?= $no ?></td>
                                                <td class="left strong"><?= $row1['name'] ?></td>
                                                <td class="left"><?= $row1['details'] ?></td>
                                                <td class="right"><?= $row2['rate'] ?></td>
                                                <td class="center"><?= $row2['quantity'] ?></td>
                                                <td class="right"><?= $row2['total'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <br>
                            <label>Service</label>
                            <div class="table-responsive-sm">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>Service</th>
                                            <th>Description</th>
                                            <th class="right">Unit Cost</th>
                                            <th class="center">Qty</th>
                                            <th class="right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql22 = "SELECT * FROM tbl_service_inv_item_enquiry where inv_id='" . $_POST['id'] . "'";


                                        $statement22 = $conn->prepare($sql22);
                                        $statement22->execute();
                                        while ($row22 = $statement22->fetch(PDO::FETCH_ASSOC)) {

                                            $sql11 = "SELECT * FROM tbl_service where id='" . $row22['service_id'] . "'";


                                            $statement11 = $conn->prepare($sql11);
                                            $statement11->execute();
                                            $row11 = $statement11->fetch(PDO::FETCH_ASSOC);


                                            $no += 1;
                                        ?>
                                            <tr>
                                                <td class="center"><?= $no ?></td>
                                                <td class="left strong"><?= $row11['name'] ?></td>
                                                <td class="left"><?= $row11['details'] ?></td>
                                                <td class="right"><?= $row22['rate'] ?></td>
                                                <td class="center"><?= $row22['quantity'] ?></td>
                                                <td class="right"><?= $row22['total'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-lg-4 col-sm-5">
                                </div>
                                <div class="col-lg-4 col-sm-5 ml-auto">
                                    <table class="table table-clear">
                                        <tbody>
                                            <tr>
                                                <td class="left">
                                                    <strong class="text-dark">Subtotal</strong>
                                                </td>
                                                <td class="right"><?= $invoice['subtotal'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">
                                                    <strong class="text-dark">Discount (<?= $invoice['discount'] ?>%)</strong>
                                                </td>
                                                <td class="right"><?php
                                                                    echo $discount = $invoice['subtotal'] * ($invoice['discount'] / 100);
                                                                    ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">
                                                    <strong class="text-dark">GST (<?= $invoice['gst_rate'] ?>%)</strong>
                                                </td>
                                                <td class="right"><?php
                                                                    $gst_rate = ($invoice['subtotal'] - $discount) * ($invoice['gst_rate'] / 100);
                                                                    echo number_format1($gst_rate, 2);
                                                                    ?></td>
                                            </tr>
                                            <tr>
                                                <td class="left">
                                                    <strong class="text-dark">Total</strong>
                                                </td>
                                                <td class="right">
                                                    <strong class="text-dark"><?= $invoice['final_total'] ?></strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <p class="mb-0">Thank you for your business !</p>
                        </div>
                    </div>
                    <input id="printbtn" type="button" value="Print Invoice" onclick="window.print();">
                    <input id="printbtn" type="button" value="Go Back" onclick="goBack()">
                    <!--<button onclick="window.print()">Print </button>-->
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- end footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
</div>
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
<script>
    function goBack() {
        window.history.back();
    }
</script>

 
 <!--// preloader-->
 
  <script>
     

function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 1000);
    function checkReady() {
        if (document.getElementsByTagName('body')[0] !== undefined) {
            window.clearInterval(intervalID);
            callback.call(this);
        }
    }
}

function show(id, value) {
    document.getElementById(id).style.display = value ? 'block' : 'none';
}

onReady(function () {
    show('page', true);
    show('loading', false);
});

 </script>
</body>

</html>