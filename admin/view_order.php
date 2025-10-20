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
                           <?php if (in_array('Add Invoice',$userroles) || ($admin['role_id']==0))
                         { ?>  
                        <a href="order.php"><button class="btn btn-primary" type="submit" title="Add Invoice"> Add Invoice </button></a>
                        <?php } ?>
                    </div>
                    <div class="card-body">
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
                                     
                                        <th>Due Date</th>
                                         <?php if (in_array('Add Installment Payment', $userroles) || ($admin['role_id'] == 0) || in_array('Check Installment Payments', $userroles)|| in_array('Check Invoice Receipt', $userroles)) { ?> 
                                        <th>Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $sql = "SELECT * FROM tbl_invoice where delete_status='0' AND status = '0' order by id desc";


                                    $statement = $conn->prepare($sql);
                                    $statement->execute();


                                    while ($item = $statement->fetch(PDO::FETCH_ASSOC)) {

                                        $no += 1;

                                         $sqlq = "SELECT * FROM tbl_customer where cust_id = ? ";


                                    $stat = $conn->prepare($sqlq);
                                    $stat->execute([$item['customer_id']]);


                                 $cust = $stat->fetch();
                                    ?>

                                        <tr>
                                            <td><?= $no; ?></td>
                                          <td><?php echo date('d-m-Y', strtotime($item['build_date'])); ?></td>
                                            <td><?= $item['inv_no']; ?></td>
                                            <td><?= $cust['cust_mob']; ?></td>
                                            <td><?= $cust['cust_name']; ?></td>
                                          
                                            <!-- <td><?= $item['final_total']; ?></td> -->
                                        <td><?php echo $record_website['currency_symbol'] . number_format1($item['final_total'], 2, '.', ','); ?>-/</td>


                                           <td><?php echo date('d-m-Y', strtotime($item['due_date'])); ?></td>

                                            
                                              <?php if (in_array('Add Installment Payment', $userroles) || ($admin['role_id'] == 0) || in_array('Check Installment Payments', $userroles)|| in_array('Check Invoice Receipt', $userroles)) { ?> 
                                            <td class="d-flex">
                                                
                                                   <?php if (in_array('Add Installment Payment',$userroles) || ($admin['role_id']==0))
                         { ?>  
                                                <a href='#' onclick="editForm(event, <?php echo $item['id'] ?>, 'edit.php')" title="Add Installment Payments "   class="btn btn-info btn-sm mr-1"><i class="fas fa-rupee-sign "></i></a>
                                                
                                                <?php } ?>
                                                
                                                   <?php if (in_array('Check Installment Payments',$userroles) || ($admin['role_id']==0))
                         { ?>  
                                                <a href='#' onclick="editForm(event, <?php echo $item['inv_no'] ?>, 'view_payorder.php')" target="_blank" title="Check Installment Payments "  class="btn btn-warning btn-sm mr-1"><i class="fas fa-money-bill-alt"></i></a>
<?php  } ?>
           
              <?php if (in_array('Check Invoice Receipt',$userroles) || ($admin['role_id']==0))
                         { ?>                                       
                                                <a href='#' target="_blank" title="Print" onclick="editForm(event, <?php echo $item['id'] ?>, 'print.php')" title="Invoice Print" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-print"></i></a>
                                                
                                                  <a href='#' target="_blank" title="Print" onclick="editForm(event, <?php echo $item['id'] ?>, 'print_inv.php')" title="Invoice Print" class="btn btn-blue btn-sm mr-1"><i class="fas fa-print"></i></a>
                                                 <a href='#' target="_blank" title="Print" onclick="editForm(event, <?php echo $item['id'] ?>, 'inv-print.php')" title="Invoice Print" class="btn btn-success btn-sm mr-1"><i class="fas fa-print"></i></a>
                                                 
                                                 
                                                 
                                                 
                                                <?php  } ?>
                                            
                                            </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Build Date</th>
                                        <th>Invoice No.</th>
                                        <th>Customer No.</th>
                                        <th>Customer Name</th>
                                      
                                        <th>Total</th>
                                     
                                        <th>Due Date</th>
                                          <?php if (in_array('Add Installment Payment', $userroles) || ($admin['role_id'] == 0) || in_array('Check Installment Payments', $userroles)|| in_array('Check Invoice Receipt', $userroles)) { ?> 
                                        <th>Action</th>
                                        <?php } ?>
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


<script>
    function editForm(event, id, file) {
        event.preventDefault(); // Prevent the default link behavior

        // Create a form dynamically
        var form = document.createElement('form');
        form.action = file;
        form.method = 'post';

        // Create a hidden input field for the ID
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = id;

        // Append the input field to the form
        form.appendChild(input);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>