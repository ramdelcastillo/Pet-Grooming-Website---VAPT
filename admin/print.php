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
$sql = "SELECT * FROM tbl_invoice where  id='" . $_POST['id'] . "'";


$statement = $conn->prepare($sql);
$statement->execute();
$invoice = $statement->fetch(PDO::FETCH_ASSOC);

// print_r($invoice);
// exit;

$sql = "SELECT * FROM tbl_manage_website";
$statement = $conn->prepare($sql);
$statement->execute();
$web = $statement->fetch(PDO::FETCH_ASSOC);

 $sqlq = "SELECT * FROM tbl_customer where cust_id = ? ";


                                    $stat = $conn->prepare($sqlq);
                                    $stat->execute([$invoice['customer_id']]);


                                 $cust = $stat->fetch();



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
                            <div class="float-left">
                                <img src="../assets/uploadImage/Logo/<?php echo $web['logo']; ?>" class="img-responsive" style="width: 300px;">
                            </div>
                            <div class="mr-5 text-center">
                                <h3><?= $web['title']; ?></h3>
                            </div>
                            <div class="float-right">
                                <h3 class="mb-0">Invoice #<?= $invoice['inv_no']; ?></h3>
                                Date:<?= date("d-m-Y", strtotime($invoice['build_date'])); ?>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-sm-6">
                                    <h5 class="mb-3">From:</h5>
                                   
                                    <h2 class="text-dark mb-1"><?= $result['fname']; ?>&nbsp;<?= $result['lname']; ?></h2>

                                    <div><?= $result['address'] ?></div>
                                    <div>Email: <?= $result['email'] ?></div>
                                    <div>Phone: <?= $result['contact'] ?></div>
                                    <div>GSTIN: <?= $result['gstin']; ?></div>
                                </div>
                                <div class="col-sm-6">
                                    <h5 class="mb-3">To:</h5>
                                    <h3 class="text-dark mb-1"><?= $cust['cust_name']; ?></h3>
                                    <div><?= $cust['cust_address']; ?></div>
                                    <div>Email: <?= $cust['cust_email']; ?></div>
                                    <div>Phone: <?= $cust['cust_mob']; ?></div>
                                    <div>GSTIN: <?= $invoice['gstin']; ?></div>
                                </div>
                            </div>
<?php
                                        $sql2 = "SELECT * FROM tbl_quot_inv_items where inv_id='" . $_POST['id'] . "'";


                                        $statement2 = $conn->prepare($sql2);
                                        $statement2->execute();
                                       $res2 = $statement2->fetchAll();
if(count($res2)>0){

?>
                            <label>Product</label>
                            <div class="table-responsive-sm">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>Product/Service</th>
                                            <th>Description</th>
                                            <!--<th class="right">Unit</th>-->
                                            <th class="center">Qty</th>
                                            <th class="right">Rate</th>

 <th class="right">Tax %</th>

                                            <th class="right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$fstot=0;
$ftax=0;
                                         $cg1=0;
                                        $sg1=0;
                                        $ig1=0;
                                       
                                        foreach($res2 as $row2){

                                            $sql1 = "SELECT * FROM tbl_product where id='" . $row2['product_id'] . "'";


                                            $statement1 = $conn->prepare($sql1);
                                            $statement1->execute();
                                            $row1 = $statement1->fetch(PDO::FETCH_ASSOC);


                                            $stmt3 = $conn->prepare("SELECT * FROM tbl_unit_grp where id='" . $row1['unit'] . "' AND delete_status = '0'");
                                            $stmt3->execute();
                                            $key3 = $stmt3->fetch();

                                            $no += 1;
                                            
                                            $stot=$row2['quantity']*$row1['unit_price'];
                                            $fstot+=$stot;
                                        ?>
                                            <tr>
                                                <td class="center"><?= $no ?></td>
                                                <td class="left strong"><?php if($row1['exp']==0){ echo 'Product- ';}else if($row1['exp']==1){ echo 'Service- ';} ?><?= $row1['name'] ?></td>
                                                <td class="left"><?= $row1['details'] ?></td>
                                                <!--<td class="right"></?= $key3['name'] ?></td>-->
                                                <td class="center"><?= $row2['quantity'] ?></td>
                                             <td class="right">
    <?php echo $web['currency_symbol'] . " " . number_format($row1['unit_price'], 2); ?>
</td>


    <td class="right">
    <?php $product=$row1['gst']; 
    $productArray = explode(',', $product);
    foreach($productArray as $pro_med){
      $stax = $conn->prepare("SELECT * FROM tbl_tax where id='" . $pro_med . "' AND delete_status = '0'");
                                            $stax->execute();
                                            $tax = $stax->fetch();  
                                            
                                          echo  $cgst=$tax['percentage'];
                                           echo '%('; echo $web['currency_symbol']; echo number_format($cgst_amt=($row2['quantity']*$row1['unit_price']*$cgst)/100,2); echo ')';
                                          echo '<br>';
                                          $ftax+=$cgst_amt;
    }
    
    
    ?></td>
    
                                                <td class="right">
    <?php echo $web['currency_symbol'] . " " . number_format($row2['total'], 2); ?>-/
</td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
<?php } ?>
                            <br>
                          

                            <div class="row align-items-center  ">
                                <div class="col-lg-4 col-sm-5">
                                    <table>
                                        <tr>
                                            <td class="left">
                                                <strong class="text-dark">Account Details </strong>
                                            </td>
                                            <td class="right">&nbsp;&nbsp;&nbsp; <?= $web['title'];?></td>
                                        </tr>
                                        <tr>
                                            <td class="left">
                                                <strong class="text-dark"> A/c No. </strong>
                                            </td>
                                            <td class="right">&nbsp;&nbsp;&nbsp; <?= $web['acc_no'];?></td>
                                        </tr>
                                        <tr>
                                            <td class="left">
                                                <strong class="text-dark"> IFSC</strong>
                                            </td>
                                            <td class="right">&nbsp;&nbsp;&nbsp; <?= $web['ifsc'];?></td>
                                        </tr>
                                        <tr>
                                            <td class="left">
                                                <strong class="text-dark"><?= $web['branch'];?></strong>
                                            </td>
                                            <td class="right">&nbsp;&nbsp;&nbsp; <?= $web['badd'];?></td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="col-lg-4 col-sm-5 ml-auto">
                                    <table class="table table-clear">
                                        <tbody>

                                            <tr>
                                                <td class="left">
                                                    <strong class="text-dark">Subtotal</strong>
                                                </td>
                                               <td class="right">
    <?php echo $web['currency_symbol'] . " " . number_format($fstot, 2); ?>-/
</td>

                                            </tr>
                                            <tr>
                                                <td class="left">
                                                    <strong class="text-dark">Tax</strong>
                                                </td>
                                               <td class="right">
    <?php echo $web['currency_symbol'] . " " . number_format($ftax, 2); ?>
</td>

                                            </tr>
                                          
                                            <tr>
                                                <td class="left">
                                                    <strong class="text-dark">Total</strong>
                                                </td>
                                                <td class="right">
                                               <strong class="text-dark">
    <?php echo $web['currency_symbol'] . " " . number_format($invoice['final_total'], 2); ?>-/
</strong>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <p class="mb-0">Terms and conditions:</p><br>
                            <p>
                            
                              <?php echo html_entity_decode($web['term']) ;?>
                            </p>
                        </div>


                        <div class="card-footer bg-white">
                            <p class="mb-0 text-right">Signtaure</p><br>
                            <p class="text-right">
                            
                            <img src="../assets/uploadImage/Logo/<?php echo $web['sign']; ?>" class="img-responsive" style="width: 150px;">
                            </p>
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