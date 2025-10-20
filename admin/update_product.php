<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>
<?php


$stmt = $conn->prepare("SELECT * FROM tbl_product WHERE id='" . $_POST['id'] . "'");
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

?>


<?php include('include/head.php'); ?>
<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>

<style>
  /* Ensure Select2 dropdown and selection box are styled correctly */
  .select2-container {
      width: 100% !important;
  }

  .select2-selection--multiple {
      min-height: 38px;
      height: auto !important;
  }

  /* Ensure dropdown is not cut off */
  #tax_div {
      position: relative;
      overflow: visible;
  }

  /* Optional: Prevent body horizontal scroll when dropdown overflows */
  body {
      overflow-x: hidden;
  }
</style>
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <!-- <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Candidate </h2>
                            <p class="pageheader-text">Candidate</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Forms</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Form Validations</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                 --><!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- validation form -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Update Product/Service</h5>
                    <div class="card-body">
                        <form class="form-horizontal" action="operation/product.php" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                    <input type="hidden" class="form-control " name="id" value="<?= $product['id']; ?>">

                                    <label for="validationCustom03">Serial No<span class="text-danger">*</span></label>

                                    <input type="text" name="pid" value="<?= $product['pid']; ?>" class="form-control" placeholder="Product Serial No" required="">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom04">Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="<?= $product['name']; ?>" required placeholder="Product Name">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom04">HSN</label>
                                    <input type="text" class="form-control" name="hsn" value="<?= $product['hsn']; ?>" required placeholder="Product HSN">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>



                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom02">Category<span class="text-danger">*</span></label>
                                    <select type="text" class="form-control js-example-basic-single" placeholder="" name="group_id" required="">
                                        <?php
                                            
                               if($_SESSION['id'] == 1){

                                        $sql = "SELECT * FROM tbl_product_grp where delete_status='0' and status='Active' ";
                               }else{
                                    $sql = "SELECT * FROM tbl_product_grp where user_id='".$_SESSION['id']."' and delete_status='0' and status='Active' ";
                               }

                                        $statement = $conn->prepare($sql);
                                        $statement->execute();


                                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                            extract($row); ?>



                                            <option value="<?php echo $id; ?>" <?php if ($id == $product['group_id']) {
                                                                                    echo "Selected";
                                                                                } ?>><?php echo $name; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom02">Investment Cost<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="purchase_price" name="purchase_price" oninput="calculateGST()" value="<?= $product['purchase_price']; ?>" required required placeholder="Product Purchase Cost">
                                    <div class="valid-feedback">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustom02">Selling Cost<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="unit_price" id="unit_price" oninput="calculateGST()" value="<?= $product['unit_price']; ?>" required required placeholder="Product Selling Cost">
                                    <div class="valid-feedback">
                                    </div>
                                </div>


                               


                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="validationCustomUsername">Description<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        </div>
                                        <textarea class="form-control" required name="details" style="height:100px;" placeholder="Product Description"><?= $product['details']; ?></textarea>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                 </div>
                 
                 
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
    <label for="has_expiry">Type</label>
    <select class="form-control" id="has_expiry" name="exp">
        <option value="">Select Type</option>
        <option value="0" <?php if($product['exp']== '0') {echo 'selected';}?>>Product</option>
        <option value="1" <?php if($product['exp']== '1') {echo 'selected';}?>>Service</option>
    </select>
</div>

<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2" id="expiry_date_div" 
     style="display: <?php echo ($product['exp'] == '1') ? 'none' : $product['exp_date']; ?>;">
    <label for="expiry_date">Expiry Date<span class="text-danger">*</span></label>
    <input type="date" class="form-control" name="exp_date" id="expiry_date" value="<?php echo $product['exp_date']; ?>">
</div>

                             <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2" id="tax_div" style="display: <?php echo ($product['exp'] == '1') ? 'none' : $product['gst']; ?>;">
                                               <label for="validationCustomUsername">Tax <span class="text-danger">*</span></label>
                                              
                                             <!--<input type="text" id="gst" name="gst" class="form-control" placeholder="GST Rate" required="" value="<?= $product['gst']; ?>">-->
                                                       
                                     <select name="gst[]" class="form-control select3"  placeholder="GST Rate" onchange="calculateGST()" multiple>
                                         <option value="">Select Tax</option>
                                         
                                         
                                    <?php
$stmt = $conn->prepare("SELECT * FROM `tbl_tax` WHERE delete_status='0'");
$stmt->execute();
$record = $stmt->fetchAll();
foreach ($record as $res) { 
$product1 =$product['gst'];
$id1 = $res['id'];

$productArray = explode(',', $product1);
?>
    <option value="<?php echo $res['id']; ?>" data-percentage="<?php echo $res['percentage']; ?>" <?php if(in_array($id1, $productArray)){ echo 'selected'; } ?> >
        <?php echo $res['name']; ?> (<?php echo $res['percentage']; ?>%)
    </option>
<?php } ?>
                              
                                         </select>
                                         
                                                </div>
                                                
                                                
                                           <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2" id="minimum_cost" style="display: <?php echo ($product['exp'] == '1') ? 'none' : $product['min_stock']; ?>;">
                                               <label for="validationCustomUsername">Minimum Stock<span class="text-danger">*</span></label>
                                              
                                     <input type="number" name="min_stock" class="form-control" id="min_stock" placeholder="Enter Minimum Stock" value="<?php echo $product['min_stock'];?>" required="">
                                 </div>     
                                                
                                                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2" id="purchase_tax" style="display: <?php echo ($product['exp'] == '1') ? 'none' : $product['purchase_gst']; ?>;">
                                    <label for="validationCustom04">Cost of Purchase After GST </label>
                                    <input type="text" class="form-control" id="purchase_gst" name="purchase_gst" value="<?= $product['purchase_gst']; ?>" required placeholder="Product Name" readonly="">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2" id="selling_tax" style="display: <?php echo ($product['exp'] == '1') ? 'none' : $product['selling_gst']; ?>;">
                                    <label for="validationCustom04">Cost of Selling After GST </label>
                                    <input type="text" class="form-control" id="selling_gst" name="selling_gst" value="<?= $product['selling_gst']; ?>" required placeholder="Product Name" readonly="">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                           
                                              
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                        <div class="valid-feedback">
                                        </div>
                                    </div>
                                   


                                   
                               
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <button class="btn btn-primary" type="submit" name="btn_edit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end validation form -->
                <!-- ============================================================== -->
            </div>

        </div>

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
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <?php include('include/footer.php'); ?>
           <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
           <script>
$(document).ready(function () {
    $('.select3').select2({
        width: '100%',
        dropdownParent: $('#tax_div') // Prevents overflow clipping
    });
});
    $(document).ready(function () {
   

        $('#has_expiry').on('change', function () {
            if ($(this).val() === '0') { // Product selected
                $('#expiry_date_div').show();
                $('#tax_div').show();
                 $('#selling_cost').show();
                  $('#minimum_cost').show();
                   $('#purchase_tax').show();
                    $('#selling_tax').show();
                
            } else { // Service or blank
                $('#expiry_date_div').hide();
                 $('#selling_cost').hide();
                  $('#minimum_cost').hide();
                   $('#purchase_tax').hide();
                    $('#selling_tax').hide();
                $('#tax_div').hide();
                $('#expiry_date').val('');
                 $('#unit_price').val('');
                  $('#min_stock').val('');
                   $('#purchase_gst').val('');
                    $('#selling_gst').val('');
                $('select[name="gst[]"]').val(null).trigger('change');
            }
        });
    });
</script>
       <script>
document.addEventListener("DOMContentLoaded", function () {
    let gstSelect = document.querySelector(".select3");
    let purchasePriceInput = document.getElementById("purchase_price");
    let unitPriceInput = document.getElementById("unit_price");

    if (gstSelect) {
        gstSelect.addEventListener("change", calculateGST);
    }
    if (purchasePriceInput) {
        purchasePriceInput.addEventListener("input", calculateGST);
    }
    if (unitPriceInput) {
        unitPriceInput.addEventListener("input", calculateGST);
    }
});

function calculateGST() {
    let purchasePriceInput = document.getElementById("purchase_price");
    let unitPriceInput = document.getElementById("unit_price");
    let purchaseGSTInput = document.getElementById("purchase_gst");
    let sellingGSTInput = document.getElementById("selling_gst");
    let gstSelect = document.querySelector(".select3");

    if (!purchasePriceInput || !unitPriceInput || !gstSelect || !purchaseGSTInput || !sellingGSTInput) {
        console.error("One or more required elements are missing.");
        return;
    }

    let purchasePrice = parseFloat(purchasePriceInput.value) || 0;
    let unitPrice = parseFloat(unitPriceInput.value) || 0;

    let totalGST = 0;
    for (let option of gstSelect.selectedOptions) {
        let taxPercentage = parseFloat(option.getAttribute("data-percentage")) || 0;
        totalGST += taxPercentage;
    }

    console.log("Purchase Price:", purchasePrice);
    console.log("Unit Price:", unitPrice);
    console.log("Total GST Percentage:", totalGST);

    if (totalGST > 0) {
        let purchaseCostAfterGST = purchasePrice + (purchasePrice * totalGST / 100);
        let sellingCostAfterGST = unitPrice + (unitPrice * totalGST / 100);

        console.log("Calculated Purchase Cost After GST:", purchaseCostAfterGST);
        console.log("Calculated Selling Cost After GST:", sellingCostAfterGST);

        purchaseGSTInput.value = purchaseCostAfterGST.toFixed(2);
        sellingGSTInput.value = sellingCostAfterGST.toFixed(2);
    } else {
        purchaseGSTInput.value = "";
        sellingGSTInput.value = "";
    }
}

</script>


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


<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>

<script>
    $(document).ready(function() {
    $('.js-example-basic-single2').select2();
});
</script>
<script>
    $(document).ready(function() {
    $('.select3').select2();
});
</script>
<script>
    document.getElementById("has_expiry").addEventListener("change", function () {
        var expiryDiv = document.getElementById("expiry_date_div");
        if (this.value === "1") {
            expiryDiv.style.display = "block";
        } else {
            expiryDiv.style.display = "none";
        }
    });
</script>

</body>

</html>