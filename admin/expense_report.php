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
                        <h4>Expense Report </h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom03">From Date</label>

                                    <input type="date" class="form-control " name="fromdate" required>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom01">To Date</label>
                                    <input type="date" class="form-control " name="todate" required>
                                    <div class="valid-feedback" placeholder="User Id">
                                    </div>
                                </div>


                                <center>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                        <label for="validationCustomUsername"></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            </div>

                                            <button class="btn btn-primary" type="submit" name="search">Search</button>
                                        </div>
                                    </div>
                                    <center>

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
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Project</th>
                                        <th>Expense For</th>
                                        <th>Expense Group</th>
                                      
                                        <th>Amount</th>
                                       


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
$total=0;
                                    if (isset($_POST['search'])) {

                                        $fromdate = $_POST['fromdate'];
                                        $todate = $_POST['todate'];
                                        $type = $_POST['type'];



                                        $sql = "SELECT * FROM tbl_expense
    WHERE user_id='".$_SESSION['id']."' AND  created_date >='" . $fromdate . "' and created_date <='" . $todate . "' and delete_status='0' ";
                                    } else {
                                        $sql = "SELECT * FROM tbl_expense where user_id='".$_SESSION['id']."' AND delete_status='0'  order by id desc";
                                    }

                                    ?>





                                    <?php


                                    $statement = $conn->prepare($sql);
                                    $statement->execute();

                                    $record = $statement->fetchAll();
                                    $no = 1;
                                    foreach ($record as $key) {

                                        
$spr = "SELECT * FROM tbl_project where id= ?  AND delete_status='0'  order by id desc";
 $project = $conn->prepare($spr);
                                    $project->execute([$key['project']]);

                                    $pr = $project->fetch();

                                    ?>

                                        <tr>
                                            <td><?php echo $no;?></td>
                                             <td><?= $key['created_date']; ?></td>
                                             <td><?= $pr['name'] ?></td>
                                            <td><?= $key['expe_for'] ?></td>
                                            <td><?php
                                                $stmt = $conn->prepare("SELECT * FROM tbl_expense_grp WHERE delete_status = '0' AND status = 'Active' AND id=? ");
                                                $stmt->execute([$key['group_id']]);
                                                $record = $stmt->fetch();
                                                echo $record['name'];
                                                ?></td>
                                           

                                            <td><?= $key['amount']; ?></td>
                                           
                                        </tr>
                                    <?php $no++;
                                   $total+=$key['amount'];
                                   } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                          <th></th>
                                          <th></th>

                                        <th>Total</th>
                                      
                                        <th><?= $total; ?></th>
                                      


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