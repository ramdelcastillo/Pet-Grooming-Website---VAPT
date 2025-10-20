<?php include('include/head.php');?>
<?php include('include/header.php');?>
<?php include('include/sidebar.php');?>
<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');
?>

<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <div class="row">
            <!-- ============================================================== -->
            <!-- validation form -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Point of Sale</h5>
                    <div class="card-body">
                       <form class="row" action="operation/order.php" method="post" enctype="multipart/form-data">
                        <!-- <form class="row" action="" method="post"> -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <span class="active btnn btn btn-outline-primary" id="all"> All</span>

                                        <?php
                                        try {
                                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        } catch (PDOException $e) {
                                            echo "Connection failed: " . $e->getMessage();
                                        }

                                        $stmt_eve = $conn->prepare("SELECT * FROM tbl_product_grp where delete_status='0' and status='Active'");
                                        $stmt_eve->execute();

                                        while ($row1 = $stmt_eve->fetch(PDO::FETCH_ASSOC)) {
                                            $prod_id = $row1['id'];
                                        ?>
                                            <span class="btnn btn btn-outline-primary" id="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></span>
                                        <?php } ?>

                                        <div class="spacer py-3"></div>

                                        <div id="parent" class="row">
                                            <?php
                                            try {
                                                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            } catch (PDOException $e) {
                                                echo "Connection failed: " . $e->getMessage();
                                            }

                                            // Fetch products based on the selected product group
                                            $stmt = $conn->prepare("SELECT * FROM tbl_product where delete_status='0' and group_id = :prod_id");


                                            $stmt->bindParam(':prod_id', $prod_id, PDO::PARAM_INT);

                                            $stmt->execute();

                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                                <div class="box a col-md-3 text-center <?php echo $prod_id; ?>" data-product-id="<?php echo $row['id']; ?>" data-product-name="<?php echo $row['name']; ?>" data-product-price="<?php echo $row['unite_price']; ?>">
                                                    <div class="card mb-1">
                                                        <div class="card-body p-1">
                                                            <img src="../assets/uploadImage/Candidate/<?php echo $row['image']; ?>" width="100%">
                                                        </div>
                                                    </div>
                                                    <p><?php echo $row['name']; ?></p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header p-2">
                                        Order List
                                    </div>
                                    <div class="card-body">
                                        <!-- <div class="mb-2"> -->
                                            <label class="mb-2 control-label">Invoice No:</label>
                                                <div class="mb-2">
                                                  <?php $user = "select count(*) as cnt from tbl_invoice";
                                                 $statement = $conn->prepare($user);
                                                  $statement->execute();
                                                $row = $statement->fetch(PDO::FETCH_ASSOC);
                                                $new=$row['cnt']+1;
                                                ?>
                                                 <input type="text" name="inv_no" value="<?php echo $new; ?>" class="form-control" required>
                                                </div>

                                        <div class="row mb-3" >
                                          <?php $current_date=date('Y-m-d'); ?>
                                          <div class="col-md-6">
                                            <label class="form-lavel">Date</label>
                                            <input type="date" name="build_date" class="form-control " value="<?php echo$current_date;?>" data-provide="datepicker" required>
                                          </div>
                                          <div class="col-md-6">
                                            <label class="form-lavel">Customer No</label>
                                            <input type="text" name="customer_no" class="form-control">
                                          </div>
                                          <div class="col-md-6">
                                            <label class="form-lavel">Customer Name</label>
                                            <input type="text" name="customer_id" class="form-control">
                                          </div>
                                          <div class="col-md-6">
                                            <label class="form-lavel">Email</label>
                                            <input type="text" name="c_email" class="form-control">
                                          </div>
                                          <div class="col-md-12">
                                            <label class="form-lavel">Address</label>
                                            <textarea type="text" name="c_address" class="form-control"></textarea>
                                          </div>
                                        </div>

                                        <table id="orderListTable" class="table table-bordered">
                                            <thead>
                                                <th>Qty</th>
                                                <th>Order</th>
                                                <th>Unit Price</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input name="quantity[]" class="quantity-input" type="text" style="width: 34px;" value="0"></td>
                                                 
                                                    
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><i class="fa fa-trash-alt"></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                   
                                    </div>
                                    <div class="card-footer d-flex justify-content-between">
                                        <span>Total</span>
                                        <span>0.00</span>
                                    </div>
                                    <div class="gstinput card-footer d-flex justify-content-between">
                                      <span>GST %</span>
                                      <input type="text" name="gst_rate" id="gst" class="form-control" value="0">
                                  </div>
                                  <div class="gstinput card-footer d-flex justify-content-between">
                                      <span>Discount(Rs)</span>
                                      <input type="text" name="discount" id="discount" class="form-control" value="0">
                                  </div>
                                  <div class="card-footer d-flex justify-content-between">
                                      <span>Total Amount</span>
                                      <span id="totalAmount">0.00</span>
                                  </div>
                                  <input type="text" class="form-control" id="aquantity" name="aquantity[]">
                                  <input type="text" name="product_id[]" id="order_name" value="">
                                  <input type="text" name="rate[]" id="unit_price" value="">
                                  <input type="text" name="total[]"  id="amount" value="">
                                  <input type="text" name="final_total" id="finalTotal" class="form-control" readonly>
                                  <input type="text" name="subtotal" id="total" class="form-control" placeholder="Subtotal" readonly>
                                 <input type="text" class="form-control" id="quantity" name="quantity[]" placeholder="Qty">

                                  <button type="submit" name="btn_save" class="btn btn-primary btn-flat m-b-10 m-t-10" id="submit_check">Submit</button>

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
        <?php include('include/footer.php'); ?>
    </div>
</div>

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
<script>
    $(document).ready(function() {
        var $btns = $('.btnn').click(function() {
            if (this.id == 'all') {
                $('#parent > div').fadeIn(450);
            } else {
                var $el = $('.' + this.id).fadeIn(450);
                $('#parent > div').not($el).hide();
            }
            $btns.removeClass('active');
            $(this).addClass('active');
        });
    });
</script>

<script>
    $(document).ready(function () {
        var orderList = [];

        function updateOrderList() {
            // Clear existing rows
            $('#orderListTable tbody').empty();

            var subtotal = 0;

            // Loop through the orderList and add rows for each product
            orderList.forEach(function (product, index) {
                var amount = product.qty * product.unitPrice;
                subtotal += amount;

                $('#orderListTable tbody').append(`
                    <tr>
                        <td>${product.qty}</td>
                        <td>${product.name}</td>
                        <td>${product.unitPrice.toFixed(2)}</td>
                        <td>${amount.toFixed(2)}</td>
                        <td><i class="fa fa-trash-alt delete-row" data-index="${index}"></i></td>
                    </tr>
                `);
            });

            // Update the total amount in the table footer
            $('.card-footer span:last-child').text(subtotal.toFixed(2));

            // Apply GST
            var gstPercentage = parseFloat($('#gst').val()) || 0;
            var gstAmount = (subtotal * gstPercentage) / 100;

            // Apply discount
            var discountAmount = parseFloat($('#discount').val()) || 0;

            // Calculate the total amount after applying GST and discount
            var totalAmount = subtotal + gstAmount - discountAmount;

            // Update the total amount in the table footer
            $('#totalAmount').text(totalAmount.toFixed(2));

            // Update hidden input fields with values for Order, Unit Price, and Amount
            var lastProduct = orderList[orderList.length - 1];
             $('#order_name').val(prodId);
            // $('#order_name').val(lastProduct.name);
            $('#unit_price').val(lastProduct.unitPrice.toFixed(2));
            $('#amount').val((lastProduct.qty * lastProduct.unitPrice).toFixed(2));
            $('#finalTotal').val(totalAmount.toFixed(2));
            $('#total').val(subtotal.toFixed(2));
//            var totalQuantity = orderList.reduce((total, product) => total + product.qty, 0);
// $('#quantity').val(totalQuantity);
// orderList.forEach(function (product, index) {
//         $('.product-quantity').eq(index).val(product.qty);
//     });

        }

        $('#parent').on('click', '.box', function () {
            var prodId = $(this).data('product-id');

            $.ajax({
                type: 'POST',
                url: 'fetch_unit_price.php',
                data: { prodId: prodId },
                dataType: 'json',
                success: function (response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        // Check if the product is already in the order list
                        var existingProduct = orderList.find(item => item.id === prodId);

                        if (existingProduct) {
                            // If it's already in the list, increment the quantity
                            existingProduct.qty++;

                            // Check if the entered quantity exceeds the available quantity
                            if (existingProduct.qty > response.openning_stock) {
                                alert('Entered quantity exceeds available quantity.');
                                existingProduct.qty--; // Decrement the quantity back
                            }
                        } else {
                            // If it's not in the list, add it with quantity 1
                            var selectedProduct = {
                                id: prodId,
                                name: response.name,
                                unitPrice: parseFloat(response.unit_price),
                                qty: 1
                            };

                            // Check if the entered quantity exceeds the available quantity
                            if (selectedProduct.qty > response.openning_stock) {
                                alert('Entered quantity exceeds available quantity.');
                            } else {
                                orderList.push(selectedProduct);
                            }
                        }

                        updateOrderList();
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Event listener for deleting rows
        $(document).on('click', '.delete-row', function () {
            var index = $(this).data('index');
            orderList.splice(index, 1);
            updateOrderList();
        });

        $('#pay').click(function () {
            if (orderList.length > 0) {
                // Perform payment processing here
                console.log('Payment processed');
            }
        });

        $('#save_order').click(function () {
            if (orderList.length > 0) {
                // Perform save order processing here
                console.log('Order saved for later.');
            }
        });

        $('input[name="qty"]').on('input', function () {
            var qty = parseInt($(this).val()) || 0;
            qty = Math.max(qty, 0);

            // Update the quantity for the last selected product
            if (orderList.length > 0) {
                orderList[orderList.length - 1].qty = qty;
            }

            updateOrderList();
        });

        // Event listener for input changes in GST and discount fields
        $('#gst, #discount').on('input', function () {
            updateOrderList();
        });
    });
</script>


</body>
</html>
