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
                        <h4>Daily Sale Report </h4>
                    </div>
                    <div class="card-body">
                    
                        <br />
                        <br />

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                     
                                        <th>Invoice No.</th>
                                        <th>Product/Service Name</th>
                                        <th>Unit Sold</th>
                                        <th>Bill Amount</th>
                                       
                                       

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $dt=date('Y-m-d');
$ctot=0;
$otot=0;
$ftot=0;
                                    
                                    $sql = "SELECT * FROM tbl_invoice where delete_status='0' AND status = '0'  AND created_date=? order by id desc";
                                    $statement = $conn->prepare($sql);
                                    $statement->execute([$dt]);
                              $item123 = $statement->fetchAll();
                              foreach($item123 as $item){
                                    
 $sql1 = "SELECT * FROM tbl_quot_inv_items where  inv_id=?";
 
                                        $no += 1;
                                        
                       $statement1 = $conn->prepare($sql1);
                                    $statement1->execute([$item['id']]);


                                    $item1 = $statement1->fetchAll();
                                    foreach($item1 as $res){
                                    // print_r($res);
                                    $sql2 = "SELECT * FROM tbl_product where delete_status='0' AND id=?";
                                    $state2 = $conn->prepare($sql2);
                                    $state2->execute([$res['product_id']]);
                                    $rt2 = $state2->fetch(PDO::FETCH_ASSOC);
                                    
                                    
                                    ?>

                                        <tr>
                                            <td><?= $no; ?></td>
                                          
                                            <td><?= $item['inv_no']; ?></td>
                                            
                                            
                                            <td><?= $rt2['name']; ?></td>
                                            
                                            
                                            <td><?php
                                 
                                    echo $res['quantity']; ?>
                                            
                                            
                                            </td>
                                            <td><?php echo $record_website['currency_symbol'] . number_format1($res['total'], 2, '.', ','); ?></td>
                                            
                                            <!-- <td><?= $item['final_total']; ?></td> -->
                                           
                                           
                                        </tr>
                                    <?php 
                                     $ftot+=$res['total'];
                                   
                                  
                                    }
                                    
                                    }
                                    
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                         <th>#</th>
                                        <th></th>
                                        <th></th>
                                        
                                        
                                        <th>Total</th>
                                        <th><?php echo $record_website['currency_symbol'];?><?php echo number_format1($ftot, 2, '.', ','); ?></th>

                                       
                                         

                                    </tr>
                                </tfoot>
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


</body>

</html>