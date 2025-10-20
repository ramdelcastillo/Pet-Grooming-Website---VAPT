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
                        <h4>Sale Report </h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom03">From Date</label>

                                    <input type="date" class="form-control " name="fromdate" required value="<?php $_POST['fromdate']; ?> ?>">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom01">To Date</label>
                                    <input type="date" class="form-control " name="todate" required value="<?php echo $todate; ?>">
                                    <div class="valid-feedback" placeholder="User Id">
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

                        </form>
                        <br />
                        <br />

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Build Date</th>
                                        <th>Invoice No.</th>
                                        <th>Customer No.</th>
                                        <th>Customer Name</th>
                                        
                                        <th>Total</th>
                                        <th>Balance</th>
                                        <th>Due Date</th>
                                        <th>Created Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
$ftot=0;
$fbalance=0;
                                    if (isset($_POST['search'])) {

                                        $fromdate = $_POST['fromdate'];
                                        $todate = $_POST['todate'];
                                        $type = $_POST['type'];



                                        $sql = "SELECT * FROM tbl_invoice
    WHERE  created_date >='" . $fromdate . "' and created_date <='" . $todate . "' and delete_status='0' AND status = '0' ";
                                    } else {
                                        $sql = "SELECT * FROM tbl_invoice where delete_status='0' AND status = '0'  order by id desc";
                                    }

                                    ?>





                                    <?php


                                    $statement = $conn->prepare($sql);
                                    $statement->execute();


                                    while ($item = $statement->fetch(PDO::FETCH_ASSOC)) {

                                        $no += 1;
                                    ?>

                                        <tr>
                                            <td><?= $no; ?></td>
                                          <td><?php echo date('d-m-Y', strtotime($item['build_date'])); ?></td>

                                            <td><?= $item['inv_no']; ?></td>
                                            
                                            
                                            <td> <?php
                                    $stmt2 = $conn->prepare("SELECT * FROM `tbl_customer` WHERE cust_id=?");
                                    // print_r($stmt2);
                                    $stmt2->execute([$item['customer_id']]);
                                    //  print_r($stmt2);
                                    $record2 = $stmt2->fetch();
                                    echo $record2['cust_mob']; ?></td>
                                            
                                            
                                            <td>
                                            <?php
                                    $stmt2 = $conn->prepare("SELECT * FROM `tbl_customer` WHERE cust_id=?");
                                    // print_r($stmt2);
                                    $stmt2->execute([$item['customer_id']]);
                                    //  print_r($stmt2);
                                    $record2 = $stmt2->fetch();
                                    echo $record2['cust_name']; ?>
                                            
                                            
                                            </td>
                                            
                                            <!-- <td><?= $item['final_total']; ?></td> -->
                                           <td><?php echo $record_website['currency_symbol'] . number_format1($item['final_total'], 2, '.', ','); ?>-/</td>
<td><?php echo $record_website['currency_symbol'] . number_format1($item['due_total'], 2, '.', ','); ?>-/</td>
                                          <td><?php echo date('d-m-Y', strtotime($item['due_date'])); ?></td>
<td><?php echo date('d-m-Y', strtotime($item['created_date'])); ?></td>

                                        </tr>
                                    <?php 
                                    
                                    $ftot+=$item['final_total'];
                                    $fbalance+=$item['due_total'];
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                         <th></th>
                                        <th></th>
                                       
                                        <th>Total</th>
                                    <th><?php echo $record_website['currency_symbol'] . number_format1($ftot, 2, '.', ','); ?>-/</th>
<th><?php echo $record_website['currency_symbol'] . number_format1($fbalance, 2, '.', ','); ?>-/</th>
                                         <th></th>
                                         <th></th>

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