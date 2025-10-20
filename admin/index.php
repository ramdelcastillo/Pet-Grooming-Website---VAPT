<?php
  error_reporting(0);
   require_once('../assets/constants/config.php');
   require_once('../assets/constants/check-login.php');
   
   require_once('../assets/constants/fetch-my-info.php');
   ?>
<?php include('include/head.php') ?>
<?php include('include/header.php') ?>
<?php include('include/sidebar.php'); ?>
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
<div class="dashboard-wrapper">
   <div class="dashboard-ecommerce">
      <div class="container-fluid dashboard-content ">
         <!-- ============================================================== -->
         <!-- pageheader  -->
         <!-- ============================================================== -->
         <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
               
            </div>
         </div>
         <div class=" mt-2 mb-4">
   <div class="row justify-content-center">
      <div class="col-md-12 col-12">
         <div class="d-flex">
            <a href="https://mayurik.com" class="bg-orange text-decoration-none p-2 text-white rounded-6">Announcement</a>
         <marquee scrollamount="10" bgcolor="#f1f1f1" onMouseOver="this.stop()" onMouseOut="this.start()" style="padding: 10px; font-size: 16px; color: red;">
          <b>If you want to do any website designing or software development work contact me at mdkhairnar92@gmail.com
</b>
            </marquee>
         </div>
      </div>
   </div>
</div>


  <div class="modal animate__animated animate__backInDown" id="refreshModal" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       
       <div class="modal-body">
        <img src="assets/images/hireme.gif" class="popup-img2" width="100%">
       </div>
     </div>
   </div>
   </div>   
         <!-- ============================================================== -->
         <!-- end pageheader  -->
         <!-- ============================================================== -->
         <div class="ecommerce-widget">
            <div class="row">
               <!-- ============================================================== -->
               <!-- sales  -->
               <!-- ============================================================== -->
               
               
               
               
                  <?php if (in_array('Total Product Category Count',$userroles) || ($admin['role_id']==0))
                         { ?>  
               <a href="category.php" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                  <div class="card border-3 dashboard bg-primary">
                     <div class="card-body py-4 pt-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                           <i class="ti  ti-package me-2"></i>
                           <div class="text-right">
                              <div class="metric-value d-inline-block">
                                 <?php
                                    $nume1 = $conn->query("SELECT COUNT(*) FROM tbl_product_grp where delete_status='0'")->fetchColumn();
                                    /*echo "<br>Number of records : ". $nume;
                                    */
                                //   print_r($nume1);exit;
                                    ?>
                                 <h1 class="mb-1"><?php echo $nume1; ?></h1>
                              </div>
                              <h5 class="text-white">Total Category</h5>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
               <?php } ?>
               <!-- ============================================================== -->
               <!-- end sales  -->
               <!-- ============================================================== -->
               <!-- ============================================================== -->
               <!-- new customer  -->
               <!-- ============================================================== -->
                <?php if (in_array('Total Product Count',$userroles) || ($admin['role_id']==0))
                         { ?>  
               <a href="productdisplay.php" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                  <div class="card border-3 dashboard bg-success">
                     <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                           <i class="ti ti-box me-2"></i>
                              <div class="text-right">
                                 <div class="metric-value d-inline-block">
                                 <?php
                                    $nume2 = $conn->query("SELECT COUNT(*) FROM tbl_product where delete_status='0' and exp = '0' ")->fetchColumn();
                                    /*echo "<br>Number of records : ". $nume;
                                    */
                                    
                                    ?>
                                 <h1 class="mb-1"><?php echo $nume2; ?></h1>
                                 </div>
                                 <h5 class="text-white">Total Product</h5>
                              </div>
                        </div>
                     </div>
                  </div>
               </a>
               <?php } ?>
               
               
                  <?php if (in_array('Total Service Count',$userroles) || ($admin['role_id']==0))
                         { ?>  
               <a href="productdisplay.php" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                  <div class="card border-3 dashboard bg-warning">
                     <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                           <i class="ti ti-tool me-2"></i>
                              <div class="text-right">
                                 <div class="metric-value d-inline-block">
                                 <?php
                                    $nume2 = $conn->query("SELECT COUNT(*) FROM tbl_product where delete_status='0' and exp = '1' ")->fetchColumn();
                                    /*echo "<br>Number of records : ". $nume;
                                    */
                                    
                                    ?>
                                 <h1 class="mb-1"><?php echo $nume2; ?></h1>
                                 </div>
                                 <h5 class="text-white">Total Services</h5>
                              </div>
                        </div>
                     </div>
                  </div>
               </a>
               <?php } ?>
               
               
                   <?php if (in_array('Total Customer Count',$userroles) || ($admin['role_id']==0))
                         { ?>  
                  <a href="view_customer.php" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                  <div class="card border-3 dashboard bg-info">
                     <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                           <i class="ti ti-users me-2"></i>
                              <div class="text-right">
                                 <div class="metric-value d-inline-block">
                                 <?php
                                    $nume2 = $conn->query("SELECT COUNT(*) FROM tbl_customer ")->fetchColumn();
                                    /*echo "<br>Number of records : ". $nume;
                                    */
                                    
                                    ?>
                                 <h1 class="mb-1"><?php echo $nume2; ?></h1>
                                 </div>
                                 <h5 class="text-white">Total Customers</h5>
                              </div>
                        </div>
                     </div>
                  </div>
               </a>
               <?php  } ?>
               
                     <?php if (in_array('Total Customer Count',$userroles) || ($admin['role_id']==0))
                         { ?>  
                  <a href="view_user.php" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                  <div class="card border-3 dashboard bg-primary">
                     <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                           <i class="ti ti-users me-2"></i>
                              <div class="text-right">
                                 <div class="metric-value d-inline-block">
                                 <?php
                                    $nume2 = $conn->query("SELECT COUNT(*) FROM tbl_admin ")->fetchColumn();
                                    /*echo "<br>Number of records : ". $nume;
                                    */
                                    
                                    ?>
                                 <h1 class="mb-1"><?php echo $nume2; ?></h1>
                                 </div>
                                 <h5 class="text-white">Total Users</h5>
                              </div>
                        </div>
                     </div>
                  </div>
               </a>
               <?php  } ?>
               <!-- ============================================================== -->
               <!-- end new customer  -->
               <!-- ============================================================== -->
               <!-- ============================================================== -->
               <!-- visitor  -->
               <!-- ============================================================== -->
               
                <?php if (in_array('Total Orders Count',$userroles) || ($admin['role_id']==0))
                         { ?>  
               <a href="view_order.php" class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                  <div class="card border-3 dashboard bg-danger">
                     <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                           <i class="ti ti-shopping-cart"></i>
                           <div class="text-right">
                              <div class="metric-value d-inline-block">
                                 <?php
                                    $nume5 = $conn->query("SELECT COUNT(*) FROM tbl_invoice where status = '0' AND delete_status='0'")->fetchColumn(); ?>
                                 <h1 class="mb-1"><?php echo $nume5; ?></h1>
                              </div>
                              <h5 class="text-white">Total Orders</h5>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
<?php } ?>


       
               <!-- ============================================================== -->
               <!-- end visitor  -->
               <!-- ============================================================== -->
               <!-- ============================================================== -->
               <!-- total orders  -->
               <!-- ============================================================== -->
     
            </div>
            <div class="row">
               <!-- ============================================================== -->
               <!-- ============================================================== -->
               <!-- recent orders  -->
               <!-- ============================================================== -->
               
                  <?php if (in_array('Recent Orders',$userroles) || ($admin['role_id']==0))
                         { ?>  
               <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                  <div class="card">
                     <h5 class="card-header">Recent Order</h5>
                     <div class="card-body p-0">
                        <div class="table-responsive">
                           <table class="table">
                              <thead class="bg-light">
                                 <tr class="border-0">
                                    <th class="border-0">SrNo</th>
                                    <th class="border-0">Build Date</th>
                                    <th class="border-0">Invoice No</th>
                                    <th class="border-0">Customer No</th>
                                    <th class="border-0">Customer Name</th>
                                 
                                    <th class="border-0">Total</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                    $sql = "SELECT * FROM tbl_invoice where delete_status='0' AND status = '0' order by id desc limit 10";
                                    
                                    
                                    $statement = $conn->prepare($sql);
                                    $statement->execute();
                                    
                                    
                                    while ($item = $statement->fetch(PDO::FETCH_ASSOC)) {
                                        $subtotal += $item['total'];
                                        $tax_amount += $item['tax_amount'];
                                        $taxable_amount += $item['taxable_amount'];
                                    
                                        extract($item);
                                        $sql2 = "SELECT * FROM tbl_quot_inv_items where inv_id='" . $id . "'";
                                    
                                    
                                        $statement2 = $conn->prepare($sql2);
                                        $statement2->execute();
                                        $row2 = $statement2->fetch(PDO::FETCH_ASSOC);
                                    
                                        $sql1 = "SELECT * FROM tbl_product where id='" . $row2['product_id'] . "'";
                                    
                                    
                                        $statement1 = $conn->prepare($sql1);
                                        $statement1->execute();
                                        $row1 = $statement1->fetch(PDO::FETCH_ASSOC);
                                    
                                      $sqlq = "SELECT * FROM tbl_customer where cust_id = ? ";
                                    
                                    
                                    $stat = $conn->prepare($sqlq);
                                    $stat->execute([$item['customer_id']]);
                                    
                                    
                                    $cust = $stat->fetch();
                                        $no += 1;
                                    ?>
                                 <tr>
                                    <td><?= $no; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($item['build_date'])); ?></td>
                                    <td><?= $item['inv_no']; ?></td>
                                    <td><?= $cust['cust_mob']; ?></td>
                                    <td><?= $cust['cust_name']; ?></td>
                                  
                                    <td><?= number_format($item['final_total'],2); ?>-/</td>
                                    <?php } ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <?php  } ?>
               <!-- ============================================================== -->
               <!-- end recent orders  -->
               <!-- ============================================================== -->
               <!-- ============================================================== -->
               <!-- customer acquistion  -->
               <!-- ============================================================== -->
               <!-- ============================================================== -->
               <!-- end customer acquistion  -->
               <!-- ============================================================== -->
            </div>
                <?php if (in_array('Monthly Income Graph',$userroles) || ($admin['role_id']==0))
                         { ?> 
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body">
                     <div id="chart_div" style="width: 100%; height: 500px;"></div>
                  </div>
               </div>
            </div>
          <?php } ?>
            <!-- ============================================================== -->
            <!-- end sales traffice country source  -->
            <!-- ============================================================== -->
         </div>
      </div>
      <!-- ============================================================== -->
      <!-- footer -->
      <!-- ============================================================== -->
      <?php include('include/footer.php'); ?>
      <!-- end footer -->
      <!-- ============================================================== -->
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
// Ensure that all months from January to December are included
$months = [
    '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
    '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
    '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
];

// Fetch monthly income (paid_amt from tbl_invoice)
$incomeQuery = "
SELECT 
    DATE_FORMAT(created_date, '%m') as month, 
    SUM(paid_amt) as total_income
FROM 
    tbl_invoice 
WHERE 
    delete_status = '0' 
GROUP BY 
    DATE_FORMAT(created_date, '%m')
ORDER BY 
    month ASC
";
$stmtIncome = $conn->prepare($incomeQuery);
$stmtIncome->execute();
$incomeTransactions = $stmtIncome->fetchAll(PDO::FETCH_ASSOC);

// Initialize data array with all months set to zero for income
$dataArray = [['Month', 'Income']];
foreach ($months as $key => $month) {
    $dataArray[] = [$month, 0]; // Default values (0)
}

// Fill the data array with the fetched income transactions
foreach ($incomeTransactions as $transaction) {
    $monthIndex = (int)$transaction['month'];
    $dataArray[$monthIndex][1] = (float)$transaction['total_income'];
}

// Encode the data array to JSON format
$dataJson = json_encode($dataArray);
?>
<script>
   // Load the Google Charts library
   google.charts.load('current', {
       packages: ['corechart', 'bar']
   });
   google.charts.setOnLoadCallback(drawChart);
   
   function drawChart() {
       // Parse the PHP-generated JSON object in JavaScript
       var data = google.visualization.arrayToDataTable(<?php echo $dataJson; ?>);
   
var options = {
    chart: {
        title: '📊 Monthly Income', // Added chart icon
        subtitle: 'Based on financial records'
    },
    hAxis: {
        title: 'Total Amount',
        minValue: 0,
    },
    vAxis: {
        title: 'Month'
    },
    bars: 'horizontal',
    axes: {
        y: {
            0: {
                side: 'right'
            }
        }
    }
};
   
       var chart = new google.charts.Bar(document.getElementById('chart_div'));
       chart.draw(data, google.charts.Bar.convertOptions(options));
   }
</script>
<script>
  $(document).ready(function() {
    setTimeout(function() {
      $('#refreshModal').modal('show');
    }, 7000); // 7000 milliseconds = 7 seconds
  });
</script>
</body>
</html>