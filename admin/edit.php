<?php include('include/head.php'); ?>
<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>
<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');
?>

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Add Installment</h5>
                    <div class="card-body">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM tbl_invoice WHERE id='" . $_POST['id'] . "'");
                        $stmt->execute();
                        $product = $stmt->fetch(PDO::FETCH_ASSOC);

                        $sqlq = "SELECT * FROM tbl_customer where cust_id = ? ";


                                    $stat = $conn->prepare($sqlq);
                                    $stat->execute([$product['customer_id']]);


                                 $cust = $stat->fetch();
                        ?>
                        <form id="add-result" class="sign-in-form mt-32 add_customer row">
                            <input type="hidden" class="form-control " name="id" value="<?= $product['id']; ?>">
                            <input type="hidden" class="form-control " name="paid_amt" value="<?= $product['paid_amt']; ?>">

                            <?php $current_date = date('Y-m-d'); ?>
                            <div class="mb-3 col-md-6">
                                <label class="txt-lbl">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" id="text" name="cust_name" value="<?php echo $cust['cust_name']; ?>" class="form-control">
                                <div class="form_bottom_boder"></div>
                            </div>
                           
                            <div class="mb-3 col-md-6">
                                <label class="txt-lbl">Date<span class="text-danger">*</span></label>
                                <input type="date" name="build_date" class="form-control" value="<?php echo $product['build_date']; ?>" data-provide="datepicker" required readonly>
                                <div class="form_bottom_boder"></div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="txt-lbl">Invoice No.<span class="text-danger">*</span></label>
                                <?php 
                                $user = "select count(*) as cnt from tbl_invoice";
                                $statement = $conn->prepare($user);
                                $statement->execute();
                                $row = $statement->fetch(PDO::FETCH_ASSOC);
                                $new = 10000 + $row['cnt'] + 1;
                                ?>
                                <input type="text" value="<?php echo $product['inv_no']; ?>" name="inv_no" value="<?php echo sprintf('%04d', intval($new)) ?>" class="form-control" required readonly>
                                <div class="form_bottom_boder"></div>
                            </div>
                            <input type="hidden" name="subtotal" id="subtotal" class="form-control" value="<?php echo $product['subtotal']; ?>" placeholder="Subtotal" readonly="">
                            <div class="mb-3 col-md-6">
                                <label class="txt-lbl">Final Total<span class="text-danger">*</span></label>
                                <input type="text" name="final_total" id="final_total" placeholder="Total" value="<?php echo $product['final_total']; ?>" onblur="myFunction()" class="form-control">
                                <div class="form_bottom_boder"></div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="txt-lbl">Due Amount<span class="text-danger">*</span></label>
                                <input type="text" name="due_total" id="due_total" onblur="myFunction()" value="<?php echo $product['due_total']; ?>" placeholder="Due Amount" readonly="" class="form-control">
                                <div class="form_bottom_boder"></div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="txt-lbl">Installment Amount<span class="text-danger">*</span></label>
                                <input type="text" name="insta_amt" id="insta_amt" onblur="myFunction()" class="form-control" max="<?php echo $product['due_total']; ?>" required>
                                <div class="form_bottom_boder"></div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="txt-lbl">Select Payment Method</label>
                                     <select name="ptype" class="form-control" required>
  <option value="1" <?php echo ($product['ptype'] == '1') ? 'selected' : ''; ?> >CASH</option>
  <option value="2" <?php echo ($product['ptype'] == '2') ? 'selected' : ''; ?> >ONLINE</option>
  <option value="3" <?php echo ($product['ptype'] == '3') ? 'selected' : ''; ?> >CHEQUE</option>
  <option value="4" <?php echo ($product['ptype'] == '4') ? 'selected' : ''; ?> >DEBIT CARD</option>
  <option value="5" <?php echo ($product['ptype'] == '5') ? 'selected' : ''; ?> >CREDIT CARD</option>
  <option value="6" <?php echo ($product['ptype'] == '6') ? 'selected' : ''; ?> >UPI</option>
  <option value="7" <?php echo ($product['ptype'] == '7') ? 'selected' : ''; ?> >NET BANKING</option>
  <option value="8" <?php echo ($product['ptype'] == '8') ? 'selected' : ''; ?> >PAYTM</option>
  <option value="9" <?php echo ($product['ptype'] == '9') ? 'selected' : ''; ?> >GOOGLE PAY</option>
  <option value="10" <?php echo ($product['ptype'] == '10') ? 'selected' : ''; ?> >PHONEPE</option>
  <option value="11" <?php echo ($product['ptype'] == '11') ? 'selected' : ''; ?> >BANK TRANSFER</option>
</select>
                              
                            </div>
                            <div class="sign-in mt-32 col-md-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('include/footer.php'); ?>
</div>

<!-- Scripts -->
<script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<script src="assets/libs/js/main-js.js"></script>
<script src="assets/libs/js/jquery.js"></script>
<script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
<script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
<script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
<script src="assets/vendor/charts/morris-bundle/morris.js"></script>
<script src="assets/vendor/charts/c3charts/c3.min.js"></script>
<script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
<script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
<script src="assets/libs/js/dashboard-ecommerce.js"></script>

<script>
    $(document).ready(function() {
        $('.add_customer').submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            var formData = $(this).serialize(); // Get form data

            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: 'operation/paid.php',
                data: formData,
                success: function(response) {
                    var responseData = JSON.parse(response);
                    if (responseData.status === 'success') {
                        window.location.href = 'view_order.php';
                    } else {
                        $('#add-result').html(responseData.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

  function myFunction() {
    var dueTotal = parseFloat(document.getElementById("due_total").value) || 0;
    var installmentAmount = parseFloat(document.getElementById("insta_amt").value) || 0;
    var finalTotal = parseFloat(document.getElementById("final_total").value) || 0;

    // Set max limit dynamically
    document.getElementById("insta_amt").setAttribute("max", dueTotal);

    if (installmentAmount > dueTotal) {
      document.getElementById("insta_amt").value = dueTotal; // Restrict entry
    }

    var newDueTotal = dueTotal - parseFloat(document.getElementById("insta_amt").value);
    document.getElementById("due_total").value = newDueTotal.toFixed(2);
  }

  // Restrict invalid input in real-time
  document.getElementById("insta_amt").addEventListener("input", function () {
    var dueTotal = parseFloat(document.getElementById("due_total").value) || 0;
    var installmentAmount = parseFloat(this.value) || 0;

    if (installmentAmount > dueTotal) {
      this.value = dueTotal; // Stop entry beyond due amount
    }
  });

</script>
