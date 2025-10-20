<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

// Fetch currency symbol
$sql1 = "SELECT currency_symbol FROM tbl_manage_website order by id desc";
$statement1 = $conn->prepare($sql1);
$statement1->execute();
$row1 = $statement1->fetch(PDO::FETCH_ASSOC);
$currency_symbol = $row1['currency_symbol'];
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered " id="example" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pay Date</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tbl_installement where inv_no='" . $_POST['id'] . "' order by id desc";
                                    $statement = $conn->prepare($sql);
                                    $statement->execute();
                                    $no = 0; // Initialize counter
                                    while ($item = $statement->fetch(PDO::FETCH_ASSOC)) {
                                        $no++; // Increment counter
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td>
                                                <?php
                                                $date = date_create($item['added_date']);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </td>
                                            <td><?php echo $currency_symbol . ' ' . number_format1($item['insta_amt']); ?></td>
                                            <td>
                                                <a href='#' onclick="editForm2(event, <?php echo $item['id'] ?>,  <?php echo $item['inv_no'] ?>, 'print-payment.php')" title="Print Reciept" class="btn btn-info btn-sm"><i class="fas fa-print"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('include/footer.php'); ?>
</div>
</div>
</body>

</html>


<script>
    function editForm2(event, id, inv_no, file) {
        event.preventDefault(); // Prevent the default link behavior

        // Create a form dynamically
        var form = document.createElement('form');
        form.action = file;
        form.method = 'post';

        // Create a hidden input field for the ID
        var inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'id';
        inputId.value = id;

        // Create a hidden input field for the invoice number
        var inputInvNo = document.createElement('input');
        inputInvNo.type = 'hidden';
        inputInvNo.name = 'inv_no';
        inputInvNo.value = inv_no;

        // Append the input fields to the form
        form.appendChild(inputId);
        form.appendChild(inputInvNo);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    }
</script>