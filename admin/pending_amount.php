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
        <div class="row">
            <!-- ============================================================== -->
            <!-- data table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Pending Amount of Invoice Report </h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            

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


                        <div class="container">
                        <div class="row">
                           

                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                    <div class="card border-3 border-top border-top-primary">
                                        <div class="card-body">
                                            <h5 class="text-muted">Total Pending Amount</h5>
                                            <div class="metric-value d-inline-block">
                                                <?php
                                                $expense = $conn->prepare("SELECT SUM(due_total) FROM tbl_invoice WHERE delete_status ='0' AND status='0' ");
                                                $expense->execute();
                                                $totalExpense = $expense->fetchColumn();
                                               echo $record_website['currency_symbol'] . number_format1($totalExpense, 2, '.', ',');
                                                ?>-/
                                            </div>
                                            <div class="metric-label d-inline-block float-right text-success font-weight">
                                                <i class="fas fa-credit-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                        </div>
                    </div>


                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Contact Number</th>
                                        <th>Total Amount</th>
                                        <th>Pending Amount</th>
                                        <th>Register Date</th>
                                         <th>Due Date</th>
                                   


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    

                                        $fromdate = $_POST['fromdate'];
                                        $todate = $_POST['todate'];
                                        $type = $_POST['type'];



                                        $sql = "SELECT * FROM tbl_invoice
                                   WHERE  status='0' AND  delete_status='0' AND due_total!='0' ";
                                     

                                  
                                    $statement = $conn->prepare($sql);
                                    $statement->execute();

                                    $record = $statement->fetchAll();
                                    $no = 1;
                                    foreach ($record as $key) {

                                        
   $sql2 = "SELECT * FROM tbl_customer where cust_id=? ";
                                                 $st2 = $conn->prepare($sql2);
                                                 $st2->execute([$key['customer_id']]);
                                                 
                                                 $rt2= $st2->fetch();


                                    ?>

                                        <tr>
                                            <td><?php echo $no;?></td>
                                            <td><?php echo  $rt2['cust_name']; ?> </td>
                                             <td><?php echo  $rt2['cust_mob']; ?> </td>
                                          <td><?php echo $record_website['currency_symbol'] . number_format1($key['final_total'], 2, '.', ','); ?>-/</td>
<td><?php echo $record_website['currency_symbol'] . number_format1($key['due_total'], 2, '.', ','); ?>-/</td>


                                         <td><?php echo date('d-m-Y', strtotime($key['build_date'])); ?></td>
<td><?php echo date('d-m-Y', strtotime($key['due_date'])); ?></td>

                                           
                                        </tr>
                                    <?php $no++;
                                    $tot+=$key['final_total'];
                                    $due+=$key['due_total'];
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th>#</th>
                                     <th></th>
                                     
                                        <th>Total</th>
                                 <th><?php echo $record_website['currency_symbol'] . number_format1($tot, 2, '.', ','); ?>-/</th>
<th><?php echo $record_website['currency_symbol'] . number_format1($due, 2, '.', ','); ?>-/</th>

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