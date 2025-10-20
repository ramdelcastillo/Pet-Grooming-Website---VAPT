
<link href="assets/vendor/select2/css/select2.css" rel="stylesheet" />
<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>




<?php include('include/head.php'); ?>
<?php include('include/header.php'); ?>


<?php include('include/sidebar.php'); ?>

<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <!--  <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Data Tables</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Tables</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                --> <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- data table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Wise Report </h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom03">Select User</label>

                                    <select class="form-control select2 " name="admin" required>
                                        <option value="">Select</option>
                                      <?php $stmt = $conn->prepare("SELECT * FROM `tbl_admin` where role_id != 0 and delete_status = 0 ");
                      $stmt->execute();
                      $record = $stmt->fetchAll();

                      foreach ($record as $res) { ?>

                        <option value="<?php echo $res['id'] ?>">
                        <?php echo $res['fname']." ".$res['lname'];
                      } ?>
                        </option>      
                                        </select>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                              

                              

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                        <label for="validationCustomUsername"></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            </div>

                                            <button class="btn btn-primary" type="submit" name="search">Search</button>
                                        </div>
                                    </div>
                               

                            </div>


                            <!-- <br>
                                        <center>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                <button class="btn btn-primary" type="submit" name="btn_save">Submit</button>
                                            </div>
                                          </center>
                                   -->
                        </form>
                        <br />
                        <br />

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SR No</th>
                                        <th>User Name</th>
                                        <th>Service/Product Name</th>
                                       <th> Quantity</th>
                                      
                                        <th> Price</th>
                                        <th>Total</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    
                                    
                                    
                                    <?php 
                                      $no=1;
                               
                                    if(isset($_POST['search']))
                                    {
                                      
                                  
                                  $stmt = $conn->prepare("
    SELECT * 
    FROM tbl_quot_inv_items 
    INNER JOIN tbl_product ON tbl_product.id = tbl_quot_inv_items.product_id 
    INNER JOIN tbl_invoice ON tbl_quot_inv_items.inv_id = tbl_invoice.inv_no 
    WHERE 
     tbl_invoice.user = ?
");
$stmt->execute([$_POST['admin']]);




}else{
    
         $stmt = $conn->prepare("
    SELECT * 
    FROM tbl_quot_inv_items 
    INNER JOIN tbl_product ON tbl_product.id = tbl_quot_inv_items.product_id 
    INNER JOIN tbl_invoice ON tbl_quot_inv_items.inv_id = tbl_invoice.inv_no 
   
");
$stmt->execute();


}

                                    $rec=$stmt->fetchAll();
                                    foreach($rec as $key)
                                    {
                                    
             $techStmt = $conn->prepare("SELECT fname, lname FROM tbl_admin WHERE id = ?");
    $techStmt->execute([$key['user']]);
    $tech = $techStmt->fetch();
                                    
                                    ?>
                                 <tr>
                                    <th><?php echo $no;?></th>
                                   <th><?php
                                   
                                    echo $tech['fname']." ".$tech['lname']  ; 
                                 
                                   
                                   ?></th>
                                        <th><?php if( $key['exp']==0){echo 'Product- '; }elseif( $key['exp']==1){echo 'Service- ';} ?><?php echo $key['name'];?></th>
                                    
                                        <th><?php echo $key['quantity'];?></th>
    <!--                                      <th>-->
    <!--                                      </?php-->
    <!--                                     /   $techStmt5 = $conn->prepare("SELECT * FROM tbl_unit_grp WHERE id = ?");-->
    <!--$techStmt5->execute([$key['unit']]);-->
    <!--/$tech5 = $techStmt5->fetch();-->
    <!--                                      echo $tech5['name'];?></th>-->
                                        <th><?php echo $record_website['currency_symbol']. number_format1($key['rate'], 2, '.', ','); ?>-/</th>
                                        <th><?php echo $record_website['currency_symbol']. number_format1($key['total'], 2, '.', ','); ?>-/</th>
                                       
                                     
                                     
                                 </tr>
                                 <?php  $no++; } ?>
                                 
                                 
                                 
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end data table  -->
            <!-- ============================================================== -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <?php include('include/footer.php'); ?>
    <!-- ============================================================== -->
    <!-- end footer -->
    <!-- ============================================================== -->
</div>
</div>
<!-- ============================================================== -->
<!-- end main wrapper -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->

<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<script src="assets/vendor/multi-select/js/jquery.multi-select.js"></script>
<script src="assets/libs/js/main-js.js"></script>
<script src="assets/libs/js/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="assets/vendor/datatables/js/data-table.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $(".select2").select2();
  });
</script>
</body>

</html>