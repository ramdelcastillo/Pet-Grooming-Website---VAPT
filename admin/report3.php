<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');
?>

<?php include('include/head.php'); ?>
<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profit Report</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-xl-4 mb-2">
                                    <label>From Date</label>
                                    <input type="date" class="form-control" name="fromdate" required>
                                </div>
                                <div class="col-xl-4 mb-2">
                                    <label>To Date</label>
                                    <input type="date" class="form-control" name="todate" required>
                                </div>
                                <div class="col-xl-4 mb-2">
                                    <label>&nbsp;</label><br>
                                    <button class="btn btn-primary" type="submit" name="search">Search</button>
                                </div>
                            </div>
                        </form>
                        <br><br>

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SR No</th>
                                        <th>Invoice Number</th>
                                        <th>Product Name</th>
                                        <th>Product Category</th>
                                        <th>Purchase Price</th>
                                        <th>Selling Price</th>
                                        <th>No Of Unit Sold</th>
                                        <th>Total Revenue</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ftot = 0;
                                    $fprof = 0;
                                    $no = 0;

                                    if (isset($_POST['search'])) {
                                        $fromdate = $_POST['fromdate'];
                                        $todate = $_POST['todate'];
                                        $sql = "SELECT * FROM tbl_invoice WHERE created_date >= ? AND created_date <= ? AND delete_status='0'";
                                        $params = [$fromdate, $todate];
                                    } else {
                                        $sql = "SELECT * FROM tbl_invoice WHERE delete_status='0' ORDER BY id DESC";
                                        $params = [];
                                    }

                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute($params);
                                    $invoices = $stmt->fetchAll();

                                    foreach ($invoices as $invoice) {
                                        $inv_id = $invoice['id'];

                                        // Get all products for this invoice
                                        $stmtItems = $conn->prepare("SELECT * FROM tbl_quot_inv_items WHERE inv_id = ?");
                                        $stmtItems->execute([$inv_id]);
                                        $items = $stmtItems->fetchAll();

                                        foreach ($items as $row2) {
                                            $product_id = $row2['product_id'];

                                            // Get product details
                                            $stmtProduct = $conn->prepare("SELECT * FROM tbl_product WHERE id = ?");
                                            $stmtProduct->execute([$product_id]);
                                            $row1 = $stmtProduct->fetch(PDO::FETCH_ASSOC);

                                            // Get product group/category
                                            $stmtGroup = $conn->prepare("SELECT * FROM tbl_product_grp WHERE id = ?");
                                            $stmtGroup->execute([$row1['group_id']]);
                                            $row7 = $stmtGroup->fetch(PDO::FETCH_ASSOC);

                                            $no++;
                                            $qty = $row2['quantity'];
                                            $purchase = $row1['purchase_gst'];
                                            $selling = $row1['selling_gst'];

                                            $total = $selling * $qty;
                                            $profit = ($selling - $purchase) * $qty;

                                            $ftot += $total;
                                            $fprof += $profit;
                                    ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $invoice['inv_no'] ?></td>
                                                <td><?= $row1['name'] ?></td>
                                                <td><?= $row7['name'] ?></td>
                                                <td><?= $record_website['currency_symbol'] . number_format($purchase, 2) ?></td>
                                                <td><?= $record_website['currency_symbol'] . number_format($selling, 2) ?></td>
                                                <td><?= $qty ?></td>
                                                <td><?= $record_website['currency_symbol'] . number_format($total, 2) ?></td>
                                                <td><?= $record_website['currency_symbol'] . number_format($profit, 2) ?></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" style="text-align:right">Total</th>
                                        <th></th>
                                        <th><?= $record_website['currency_symbol'] . number_format($ftot, 2) ?></th>
                                        <th><?= $record_website['currency_symbol'] . number_format($fprof, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('include/footer.php'); ?>
</div>

<!-- JS Scripts -->
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
