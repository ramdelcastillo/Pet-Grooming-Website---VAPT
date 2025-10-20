<?php
//error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>
<?php
$stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id='" . $_SESSION['id'] . "'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM tbl_manage_website ");
$stmt->execute();
$result1 = $stmt->fetch(PDO::FETCH_ASSOC);




?>

<?php
$sql = "SELECT * FROM tbl_invoice where  inv_no='" . $_POST['inv_no'] . "'";


$statement = $conn->prepare($sql);
$statement->execute();
$invoice = $statement->fetch(PDO::FETCH_ASSOC);
// $stmtq = $conn->prepare("SELECT * FROM manage_info ");
// $stmtq->execute();
// $resultq = $stmtq->fetch(PDO::FETCH_ASSOC);





$sql111 = "SELECT * FROM tbl_installement WHERE id='" . $_POST['id'] . "' ";

$statement11 = $conn->prepare($sql111);

$statement11->execute();

$result111 = $statement11->fetch(PDO::FETCH_ASSOC);



function number_format1($number, $decimal = 2) {
    // Format the number to fixed decimal places
    $number = number_format((float)$number, $decimal, '.', '');

    // Split integer and decimal parts
    $decimalPart = '';
    if (strpos($number, '.') !== false) {
        list($number, $decimalPart) = explode('.', $number);
    }

    // Indian number formatting
    $last3 = substr($number, -3);
    $restUnits = substr($number, 0, -3);

    if ($restUnits != '') {
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
        $formatted = $restUnits . "," . $last3;
    } else {
        $formatted = $last3;
    }

    return $decimal > 0 ? $formatted . "." . $decimalPart : $formatted;
}
?>



<?php include('include/head.php'); ?>

<div class="" style="background-color: #ffffff;">
   <div class="mx-auto col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="card m-0">
         <div class="card-body" style="page-break-after: always;position:relative">
            <div style="    opacity: 0.4;
    position: absolute;
    top: 250px;
    left: 334px;
    ">
               <!-- <img src="../assets/uploadImage/Logo/<?php echo $resultq['watermark']; ?>" width="200px"> -->
            </div>
            <div class="d-flex justify-content-between">
               <div>
                  <p class="mb-0"><b><?= $result['fname']; ?>&nbsp;<?= $result['lname']; ?></b></p>
                  <p class="mb-0"><?= $result['address'] ?></p>
                  <p class="mb-0">Email: <?= $result['email'] ?></p>
                  <p class="mb-0"><?= $result['contact'] ?></p>
               </div>
               <div>
                   
               
                                    
                                    
                  <p class="mb-0 text-right"><b>    <?php
                                    $stmt2 = $conn->prepare("SELECT * FROM `tbl_customer` WHERE cust_id=? ");
                                    $stmt2->execute([$invoice['customer_id']]);
                                   // print_r($stmt2);exit;
                                    $record2 = $stmt2->fetch();
                                    echo $record2['cust_name']; ?></b></p>
                  <p class="mb-0 text-right"><?= $invoice['c_address']; ?></p>
                  <p class="mb-0 text-right"><?= $invoice['customer_no']; ?></p>
                  <p class="mb-0 text-right"><?= $invoice['c_email']; ?></p>
               </div>
            </div>
            <div class="text-center">

               <h2 class="pt-3">PAYMENT RECIEPT</h2>

            </div>


            <div class="col-md-4">
               <p class="border-bottom pb-2 border-dark">Payment Date: <?php $date = date_create($result111['added_date']);
                                                                        echo date_format($date, "d/m/Y");
                                                                        ?></p>
               <p class="border-bottom pb-2 border-dark">Payment Mode: <?php if ($invoice['ptype'] == '1') {
                                                                           echo 'CASH';
                                                                        } else if ($invoice['ptype'] == '2') {
                                                                           echo 'ONLINE';
                                                                        } else if ($invoice['ptype'] == '3') {
                                                                           echo 'CHEQUE';
                                                                        } else if ($invoice['ptype'] == '4') {
                                                                           echo 'DEBIT CARD';
                                                                        } else if ($invoice['ptype'] == '5') {
                                                                           echo 'CREDIT CARD';
                                                                        } else if ($invoice['ptype'] == '6') {
                                                                           echo 'UPI';
                                                                        } else if ($invoice['ptype'] == '7') {
                                                                           echo 'NET BANKING';
                                                                        } else if ($invoice['ptype'] == '8') {
                                                                           echo 'PAYTM';
                                                                        } else if ($invoice['ptype'] == '9') {
                                                                           echo 'GOOGLE PAY';
                                                                        } else if ($invoice['ptype'] == '10') {
                                                                           echo 'PHONEPE';
                                                                        } else if ($invoice['ptype'] == '11') {
                                                                           echo 'BANK TRANSFER';
                                                                        } ?>





                                                                           
                                                                        </p>
               <!-- <p class="border-bottom pb-2 border-dark">Payment Mode: <?= $result111['ptype']; ?></p> -->
               <div class="p-4" style="background-color:#8bc34a;color:#fff;text-align:center;-webkit-print-color-adjust: exact; ">
                  <p>Total Amount<br>
                     <?php echo $result1['currency_symbol'] . ' ' . number_format1($invoice['final_total']); ?></p>
               </div>
            </div>
            <br>
            <h3>Payment For</h3>
            <div class="table-responsive-sm">
               <table class="table">
                  <thead>
                     <tr>
                        <th class="center" style="background-color: #595959;color: #fff;">Invoice Number</th>
                        <th style="background-color: #595959;color: #fff;">Invoice Date</th>
                        <th style="background-color: #595959;color: #fff;" class="right">Paid Amount</th>
                        <th style="background-color: #595959;color: #fff;" class="center">Due Amount</th>
                        <th style="background-color: #595959;color: #fff;" class="right">Amount Due</th>
                     </tr>
                  </thead>
                  <tbody>


                     <tr>
                        <?php $paid = $invoice['final_total'] - $result111['due_total']; ?>
                        <td class="center"><?= $_POST['inv_no']; ?></td>
                        <td class="left strong"><?php $formattedDate = date('d-m-Y', strtotime($invoice['build_date']));

                                                echo $formattedDate; ?></td>
                        <td class="right"> <?php echo $result1['currency_symbol'] . ' ' . number_format1($result111['insta_amt']); ?></td>
                        <td class="center"><?php echo $result1['currency_symbol'] . ' ' . number_format1($paid); ?></td>
                        <td class="right"><?php echo $result1['currency_symbol'] . ' ' . number_format1($result111['due_total']); ?></td>
                     </tr>
                  </tbody>
               </table>
               <div class="ml-auto" style="float:right;">
                  <!-- 
                  <img src="../assets/uploadImage/Logo/<?php echo $resultq['signature']; ?>" width="150px">
                  <h2 class="mb-0"><?php echo $resultq['name']; ?></h2> -->
                  <br><br><br><br><br><br>
                  <h3>Founder Of <?php echo $result1['title']; ?></h3>
               </div>
            </div>


         </div>



      </div>




      <input id="printbtn" type="button" value="Print Invoice" onclick="window.print();">
      <input id="printbtn" type="button" value="Go Back" onclick="goBack()">
      <!--<button onclick="window.print()">Print </button>-->
   </div>
   <style>
      @media print {
         table th {
            background-color: #595959;
            color: #fff;
         }

         p {
            font-size: 20px;
         }
      }

      .text-primary {
         color: #ce5051 !important;
      }

      .dashboard-main-wrapper {
         padding-top: 60px;
      }

      tr,
      td,
      th {
         position: relative;
      }
   </style>
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