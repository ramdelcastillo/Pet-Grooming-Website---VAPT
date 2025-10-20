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
         <!-- ============================================================== -->
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
                        <h3>Estimate Receipt</h3>
                     </div>
                     <div class="float-right">
                        <h3 class="mb-0">Estimate No #<?= $invoice['inv_no']; ?></h3>
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
                           <div>GSTIN: <?= $result['gstin']; ?></div>
                        </div>
                        <div class="col-sm-6">
                           <h5 class="mb-3">To:</h5>
                           <h3 class="text-dark mb-1"><?= $cust['cust_name']; ?></h3>
                           <div><?= $invoice['c_address']; ?></div>
                           <div>Email: <?= $invoice['c_email']; ?></div>
                           <div>Phone: <?= $invoice['customer_no']; ?></div>
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
                     <label>Items</label>
                     <div class="table-responsive-sm">
                        <table class="table table-striped">
                           <thead>
                              <tr>
                                 <th class="center">#</th>
                                 <th>Item</th>
                                 <th>Description</th>
                                 <th class="right">Unit</th>
                                 <th class="center">Qty</th>
                                 <th class="right">Rate</th>
                                 <?php if($cust['state']=='22'){ ?>
                                 <th class="right">CGST %</th>
                                 <th class="right">CGST Amt</th>
                                 <th class="right">SGST %</th>
                                 <th class="right">SGST Amt</th>
                                 <?php } else { ?>
                                 <th class="right">IGST %</th>
                                 <th class="right">IGST Amt</th>
                                 <?php } ?>
                                 <th class="right">Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
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
                                 ?>
                              <tr>
                                 <td class="center"><?= $no ?></td>
                                 <td class="left strong"><?= $row1['name'] ?></td>
                                 <td class="left"><?= $row1['details'] ?></td>
                                 <td class="right"><?= $key3['name'] ?></td>
                                 <td class="center"><?= $row2['quantity'] ?></td>
                                 <td class="right"><?= $row2['rate'] ?></td>
                                 <?php if($cust['state']=='22'){ ?>
                                 <td class="right"><?= $cgst=$row1['gst']/2; ?></td>
                                 <td class="right"><?= $cgst1=($row2['rate']*$cgst*$row2['quantity'])/100; ?></td>
                                 <td class="right"><?= $sgst=$row1['gst']/2; ?></td>
                                 <td class="right"><?= $sgst1=($row2['rate']*$sgst*$row2['quantity'])/100; ?></td>
                                 <?php } else { ?>
                                 <td class="right"><?= $row1['gst'] ?></td>
                                 <td class="right"><?= $igst1=($row2['rate']*$row1['gst']*$row2['quantity'])/100; ?></td>
                                 <?php } ?>
                                 <td class="right"><?= $row2['total'] ?></td>
                              </tr>
                              <?php 
                                 $cg1+=$cgst1;
                                     $sg1+=$sgst1;
                                     $ig1+=$igst1;
                                 } ?>
                           </tbody>
                        </table>
                     </div>
                     <?php } 
                        $no2 = 1;
                                                               $sql22 = "SELECT * FROM tbl_service_inv_item where inv_id='" . $_POST['id'] . "'";
                        
                        
                                                               $statement22 = $conn->prepare($sql22);
                                                               $statement22->execute();
                                                               $res22 = $statement22->fetchAll();
                                                               if(count($res22)>0){
                        ?>
                     <br>
                     <label>Services</label>
                     <div class="table-responsive-sm">
                        <table class="table table-striped">
                           <thead>
                              <tr>
                                 <th class="center">#</th>
                                 <th>Service</th>
                                 <th>Description</th>
                                 <th class="center">Qty</th>
                                 <th class="right">Rate</th>
                                 <?php if($cust['state']=='22'){ ?>
                                 <th class="right">CGST %</th>
                                 <th class="right">CGST Amt</th>
                                 <th class="right">SGST %</th>
                                 <th class="right">SGST Amt</th>
                                 <?php } else { ?>
                                 <th class="right">IGST %</th>
                                 <th class="right">IGST Amt</th>
                                 <?php } ?>
                                 <th class="right">Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 $cg=0;
                                 $sg=0;
                                 $ig=0;
                                 foreach($res22 as $row22) {
                                 
                                    $sql11 = "SELECT * FROM tbl_service where id='" . $row22['service_id'] . "'";
                                 
                                 
                                    $statement11 = $conn->prepare($sql11);
                                    $statement11->execute();
                                    $row11 = $statement11->fetch(PDO::FETCH_ASSOC);
                                 
                                 
                                 ?>
                              <tr>
                                 <td class="center"><?= $no2; ?></td>
                                 <td class="left strong"><?= $row11['name'] ?></td>
                                 <td class="left"><?= $row11['details'] ?></td>
                                 <td class="center"><?= $row22['quantity'] ?></td>
                                 <td class="right"><?= $row22['rate'] ?></td>
                                 <?php if($cust['state']=='22'){ ?>
                                 <td class="right"><?= $cgst=$row11['gst']/2; ?></td>
                                 <td class="right"><?= $camt=($row22['rate']*$cgst*$row22['quantity'])/100; ?></td>
                                 <td class="right"><?= $sgst=$row11['gst']/2; ?></td>
                                 <td class="right"><?= $samt=($row22['rate']*$sgst*$row22['quantity'])/100; ?></td>
                                 <?php } else { ?>
                                 <td class="right"><?= $row11['gst'] ?></td>
                                 <td class="right"><?= $igst=($row22['rate']*$row11['gst']*$row22['quantity'])/100; ?></td>
                                 <?php } ?>
                                 <td class="right"><?= $row22['total'] ?></td>
                              </tr>
                              <?php $no2++;
                                 $cg+=$cgst;
                                 $sg+=$sgst;
                                 $ig+=$igst;
                                 } ?>
                           </tbody>
                        </table>
                     </div>
                     <br>
                     <?php } ?>
                     <div class="row">
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
                        <div class="col-lg-8 col-sm-5 ">
                           <table class="table table-clear">
                              <tbody>
                                 <tr>
                                    <?php if($cust['state']=='22'){ ?>
                                    <td class="left  text-right">
                                       <strong class="text-dark">Total CGST</strong>
                                    </td>
                                    <td class="right">
                                       <strong class="text-dark"><?= $cg+$cg1; ?></strong>
                                    </td>
                                    <td class="left">
                                       <strong class="text-dark">Total SGST</strong>
                                    </td>
                                    <td class="right">
                                       <strong class="text-dark"><?= $sg+$sg1; ?></strong>
                                    </td>
                                    <?php } else { ?>
                                    <td class="left">
                                       <strong class="text-dark">Total IGST</strong>
                                    </td>
                                    <td class="right">
                                       <strong class="text-dark"><?= $ig+$ig1; ?></strong>
                                    </td>
                                    <?php } ?>
                                    <td class="left">
                                       <strong class="text-dark">Total</strong>
                                    </td>
                                    <td class="right text-right">
                                       <strong class="text-dark"><?= $invoice['final_total'] ?></strong>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer bg-white">
                     <p class="mb-0">Terms and conditions:</p>
                     <br>
                     <p>
                        <?php echo html_entity_decode($web['term']);?>
                     </p>
                  </div>
                  <div class="card-footer bg-white">
                     <p class="mb-0 text-right">Signtaure</p>
                     <br>
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