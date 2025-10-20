<?php include('include/head.php'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>
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
          <h5 class="card-header">Add Purchase Bill</h5>
          <div class="card-body">
            <form class="form-horizontal" action="operation/stock.php" method="post" enctype="multipart/form-data" id="add_brand">
              <div class="form-row">
                <!--<div class="form-group row col-md-6">-->
                <!--  <label class="col-sm-3 control-label">Supplier Name:</label>-->
                <!--  <div class="col-sm-9">-->


                <!--    <input type="text" name="s_name" class="form-control" data-provide="" placeholder="Supplier Name" required>-->
                <!--  </div>-->
                <!--</div> &nbsp;&nbsp;&nbsp;&nbsp;-->
                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Vendor Name:</label>
                  <div class="col-sm-9">
                    <select class="form-control " name="vendor_id" id="vendor_id">
                        <option>Select Name</option> 
                        <?php 

  $sql = "SELECT * FROM tbl_labour where delete_status='0'";
// print_r($sql);exit;
                
 $statement = $conn->prepare($sql);
 $statement->execute();

$rec=  $statement->fetchAll();                                                           
                                                     
   foreach($rec as $cust )
   {?>
                        <option value="<?php echo $cust['id']; ?>"><?php echo $cust['name']; ?></option><?php } ?>
                    </select>
                  </div>
                </div>
                
                    <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Project Name:</label>
                  <div class="col-sm-9">
                    <select class="form-control " name="project_id">
                        <option>Select project</option> 
                    
    <?php
                                    $sql = "SELECT * FROM tbl_project where delete_status='0' order by id desc";


                                    $stat = $conn->prepare($sql);
                                    $stat->execute();

                    $rec1=  $stat->fetchAll();                                                           
                                                     
             foreach($rec1 as $cust1 )
             {?>
                        <option value="<?php echo $cust1['id']; ?>"><?php echo $cust1['name']; ?></option><?php } ?>
                    </select>
                  </div>
                </div>

                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php $current_date = date('Y-m-d'); ?>

                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label"> Date</label>
                  <div class="col-sm-9">
                    <input type="date" name="build_date" class="form-control " value="<?php echo $current_date; ?>" data-provide="datepicker" required>
                  </div>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;

                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Vendor No: </label>
                  <div class="col-sm-9">
                    <input type="text" name="s_no" id="s_no" class="form-control " placeholder="Vendor No" minlength="1" maxlength="10" pattern="^[0][1-9]\d{9}$|^[1-9]\d{9}$" required title="Enter Valid Mobile No">


                  </div>
                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Bill No:</label>
                  <div class="col-sm-9">
                    <?php $user = "select * from tbl_stock GROUP BY id ORDER BY id DESC LIMIT 0,1";
                    $statement = $conn->prepare($user);
                    $statement->execute();
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    if (empty($row['id'])) {
                      $new = 1;
                    } else {
                      $new = $row['id'] + 1;
                    }

                    ?>
                    <input type="text" name="p_no" value="<?php echo $new ?>" class="form-control" required readonl>
                  </div>
                </div>
                      &nbsp;&nbsp;&nbsp;&nbsp;

                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Challan No: </label>
                  <div class="col-sm-9">
                    <input type="text" name="challan_no" class="form-control " placeholder="Challan No" >


                  </div>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;

                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Vendor Email: </label>
                  <div class="col-sm-9">
                    <input type="email" name="s_email" id="s_email" class="form-control " placeholder="Supplier Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>

                  </div>
                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Vendor Address:</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" required="" name="address" id="address" style="height:70px;" placeholder="Supplier Address"></textarea>
                  </div>
                </div>




              </div>

              <div class="form-group row">
                <div class="col-sm-1">
                  Sr no.
                </div>

                <div class="col-sm-2">
                  Product Group
                </div>

                <div class="col-sm-3">
                  Select Product
                </div>


                <div class="col-sm-1">
                  Avl.Qty
                </div>
                <div class="col-sm-1">
                  Req.Qty
                </div>

                <div class="col-sm-1">
                  Sale Price
                </div>
                <div class="col-sm-2">
                  Total
                </div>
                <!--  <div class="col-sm-1">
                                              Action
                                            </div>
                                         -->
              </div>
              <div class="mydiv">
                <div class="form-group row control-group after-add-more subdiv">
                  <div class="col-sm-1 sr_no">1</div>
                     <div class="col-sm-3">
                  <div class="col-sm-12">
                    <select name="product_group_id[]" class="form-control product_group_id" required>
                      <option value="">-Product Group-</option>
                      <?php
                      if($_SESSION['id']==1){
                          $sql1 = "SELECT * FROM tbl_product_grp where delete_status='0' order by id desc";
                      }else{
                          $sql1 = "SELECT * FROM tbl_product_grp where user_id='".$_SESSION['id']."' and delete_status='0' order by id desc";
                      }
                      
                      $sta1 = $conn->prepare($sql1);
                      $sta1->execute();
                      while ($row1 = $sta1->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                  <div class="col-sm-3">
                    <div class="col-sm-12">
                       <select name="product_id[]" class="form-control product_id select2">
          <option value="">--Select Product--</option>
          <!-- Products will be loaded dynamically -->
        </select>
                    </div>
                  </div>

                  <div class="col-sm-1">
                    <input type="number" class="form-control" id="quantity1" pattern="^[0-9]+$" name="quantity[]" placeholder="Qty" >
                    <input type="hidden" class="form-control" id="aquantity" name="aquantity[]" placeholder="Qty"  pattern="^[0-9]+$" readonly="">
                  </div>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="rate" name="rate[]" placeholder="Rate">
                  </div>
                  <div class="col-sm-2">
                    <input type="text" class="form-control total" id="total" name="total[]" placeholder="Total" readonly="">
                  </div>

                  <div class="col-sm-2">
                    <button class="btn btn-success add-more" type="button"><i class="fa fa-plus"></i></button>
                  </div>
                </div>

              </div>


              <div class="form-group row control-group">
                <label class="col-sm-6 control-label">GST %</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" id="gst_rate" name="gst_rate" placeholder="GST %" value="0" min="0" max="99">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-6 control-label">Discount</label>
                <div class="col-sm-3">
                  <input type="number" class="form-control" id="discount" name="discount" placeholder="Discount %" value="0" min="0" max="100">
                </div>
              </div>
              <input type="hidden" name="subtotal" id="subtotal" class="form-control" placeholder="Subtotal" readonly="">

           
              <div class="form-group row">
                <label class="col-sm-6 control-label"> Final Total</label>
                <div class="col-sm-3">
                  <input type="text" name="final_total" id="final_total" class="form-control" placeholder="Total" readonly="">
                </div>
              </div>

              <button type="submit" name="btn_save" class="btn btn-primary btn-flat m-b-30 m-t-30" onclick="addBrand()">Submit</button>
              <p id="GFG_DOWN" style="color: green;">

            </form>
            <div class="copy hide" style="display:none;">
              <div class="form-group control-group row subdiv">
                <div class="col-sm-1 sr_no"></div>
                 <div class="col-sm-3">
                  <div class="col-sm-12">
                    <select name="product_group_id[]" class="form-control product_group_id" required>
                      <option value="">-Product Group-</option>
                      <?php
                      if($_SESSION['id']==1){
                          $sql1 = "SELECT * FROM tbl_product_grp where delete_status='0' order by id desc";
                      }else{
                          $sql1 = "SELECT * FROM tbl_product_grp where user_id='".$_SESSION['id']."' and delete_status='0' order by id desc";
                      }
                      
                      $sta1 = $conn->prepare($sql1);
                      $sta1->execute();
                      while ($row1 = $sta1->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="col-sm-12">
                      <select name="product_id[]" class="form-control product_id select2">
          <option value="">--Select Product--</option>
          <!-- Products will be loaded dynamically -->
        </select>
                  </div>
                </div>

                <div class="col-sm-1">
                  <input type="text" class="form-control" id="quantity" name="quantity[]" placeholder="Qty" >
                  <input type="hidden" class="form-control" id="aquantity" name="aquantity[]" placeholder="Qty"  readonly="">

                </div>

                <div class="col-sm-2">
                  <input type="text" class="form-control" id="rate" name="rate[]" placeholder="Rate" required>
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control total" id="total" name="total[]" placeholder="Total" readonly="">
                </div>
                <div class="col-sm-2">
                  <button class="btn btn-danger remove" type="button"><i class="fa fa-minus"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>

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
<script type="text/javascript">
  1
  $('#class_id').change(function() {
    $("#subject_id").val('');
    $("#subject_id").children('option').hide();
    var class_id = $(this).val();
    $("#subject_id").children("option[data-id=" + class_id + "]").show();

  });
</script>
<srcipt>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#vendor_id').change(function () {
        var vendorID = $(this).val();
        if (vendorID) {
            $.ajax({
                url: 'fetch_vendor_details.php', // The PHP file to fetch vendor details
                type: 'POST',
                data: { id: vendorID },
                dataType: 'json',
                success: function (response) {
                    if (response) {
                        $('#s_email').val(response.email);
                        $('#address').val(response.address);
                        $('#s_no').val(response.contact);
                    } else {
                        alert('No details found for the selected vendor.');
                    }
                },
                error: function () {
                    alert('Error fetching vendor details.');
                }
            });
        } else {
            // Clear fields if no vendor is selected
            $('#s_email').val('');
            $('#address').val('');
            $('#s_no').val('');
        }
    });
});
</script>

</srcipt>
<script>
$(document).ready(function () {
    // Function to populate products based on product group
    function fetchProducts(productGroupId, targetDropdown) {
        $.ajax({
            url: 'fetch_products.php', // Backend script to fetch products
            type: 'POST',
            data: { product_group_id: productGroupId },
            dataType: 'json',
            success: function (response) {
                targetDropdown.empty(); // Clear the existing options
                targetDropdown.append('<option value="">--Select Product--</option>');
                $.each(response, function (index, product) {
                    targetDropdown.append(
                        '<option value="' + product.id + '">' + product.name + '</option>'
                    );
                });
            },
            error: function () {
                alert('Failed to fetch products. Please try again.');
            },
        });
    }

    // Handle change on product group dropdown
    $(document).on('change', '.product_group_id', function () {
        const productGroupId = $(this).val();
        const targetDropdown = $(this).closest('.subdiv').find('.product_id');

        if (productGroupId) {
            fetchProducts(productGroupId, targetDropdown);
        } else {
            targetDropdown.empty();
            targetDropdown.append('<option value="">--Select Product--</option>');
        }
    });

    // Add new row dynamically
    $(document).on('click', '.add-more', function () {
        const newRow = $('.copy').html();
        $('.after-add-more').after(newRow);

        // Reinitialize select2 for dynamically added rows (if using select2 plugin)
        $('.after-add-more').next().find('.select2').select2();

        // Update row numbers
        updateRowNumbers();
    });

    // Remove row
    $(document).on('click', '.remove', function () {
        $(this).closest('.control-group').remove();

        // Update row numbers
        updateRowNumbers();
    });

    // Function to update row numbers
    function updateRowNumbers() {
        let rowCount = 0;
        $('.sr_no').each(function () {
            rowCount++;
            $(this).html(rowCount);
        });
    }
});


</script>

<script>
  $(function() {
    $(".datepicker").datepicker({
      format: 'dd/mm/yyyy'
    });
  });
</script>

<script type="text/javascript">
  $("body").on("click", ".remove", function() {
    $(this).parents(".control-group").remove();
  });
</script>
<script type="text/javascript">
  $("#customer_id").on("change", function() {
    var customer_id = $(this).val();
    $.ajax({
      type: "POST",
      url: 'ajax_represent.php',
      data: {
        customer_id: customer_id
      },
      success: function(data) {
        $('#representative_id').html(data);
      }
    });
  });
</script>


<script type="text/javascript">
 

  $("body").on("click", ".remove", function() {
    $(this).parents(".control-group").remove();
    show_no();
  });

  function show_no() {
    var row_cnt = 0;
    $(".sr_no").each(function() {
      row_cnt++;
      $(this).html(row_cnt);
    });
  }
</script>

<!-- <script type="text/javascript">
  $(".add-more").on('click', function() {
    var html = $(".copy").html();
    $(".after-add-more").after(html);
    show_no();
  });

  $("body").on("click", ".remove", function() {
    $(this).parents(".control-group").remove();
    show_no();
  });

  function show_no() {
    var row_cnt = 0;
    $(".sr_no").each(function() {
      row_cnt++;
      $(this).html(row_cnt);
    });
  }
</script> -->
<script type="text/javascript">
  $(document).ready(function() {
    $('div.mydiv').on("keyup", 'input[name^="rate"]', function(event) {
      var currentRow = $(this).closest('.subdiv');
      var quantity = currentRow.find('input[name^="quantity"]').val();


      //alert(quantity);
      var unitprice = currentRow.find('input[name^="rate"]').val();
      var gst = currentRow.find('input[name^="gst"]').val();
      var subtotal = Number(quantity) * Number(unitprice);
      var tax_amount = Number(subtotal) * (Number(gst) / 100);

      currentRow.find('input[name^="tax_amount"]').val(tax_amount);
      var total = Number(quantity) * Number(unitprice) + Number(tax_amount);
      var total = +currentRow.find('input[name^="total"]').val(total);
      // $('#subtotal').val(total);
      var sum = 0;
      $('.total').each(function() {
        sum += Number($(this).val());
      });
      $('#subtotal').val(sum);
      $('#final_total').val(sum);
      var sub_text = $('#subtotal').val();
      var sub_total = Number(sub_text);
      $("#final_total").val(sub_total);
      var tot_commi = 0;
      $('.tax_amount').each(function() {
        tot_commi += Number($(this).val());
      });
      $('#total_tax_amount').val(tot_commi);
    });
    var tot_commi = 0;
    $('.taxable_amount').each(function() {
      tot_commi += Number($(this).val());
    });
    $('#total_taxable_amount').val(tot_commi);
  });

  $('div.mydiv').on("keyup", 'input[name^="quantity"]', function(event) {
    var currentRow = $(this).closest('.subdiv');
    var quantity = currentRow.find('input[name^="quantity"]').val();

    var sale_price = currentRow.find('input[name^="rate"]').val();

    var total = parseInt(sale_price) * parseInt(quantity);
    currentRow.find('input[name^="total"]').val(total);

    var rate = parseInt(total) / parseInt(quantity);


    var total = +currentRow.find('input[name^="total"]').val();
    // $('#subtotal').val(total);
    var sum = 0;
    $('.total').each(function() {
      sum += Number($(this).val());
    });
    $('#subtotal').val(sum);
    $('#final_total').val(sum);

    var sub_text = $('#subtotal').val();
    var sub_total = Number(sub_text);
    $("#final_total").val(sub_total);

    var tot_commi = 0;
    $('.tax_amount').each(function() {
      tot_commi += Number($(this).val());
    });
    $('#total_tax_amount').val(tot_commi);
    var tot_commi = 0;
    $('.taxable_amount').each(function() {
      tot_commi += Number($(this).val());
    });
    $('#total_taxable_amount').val(tot_commi);

  });

  $('div.mydiv').on("keyup", 'input[name^="gst"]', function(event) {
    var currentRow = $(this).closest('.subdiv');
    var quantity = currentRow.find('input[name^="quantity"]').val();
    var sale_price = currentRow.find('input[name^="sale_price"]').val();
    var taxable = parseInt(sale_price) * parseInt(quantity);
    currentRow.find('input[name^="taxable_amount"]').val(taxable);

    var taxable_amount = currentRow.find('input[name^="taxable_amount"]').val();
    var gst = currentRow.find('input[name^="gst"]').val();
    var rate = Number(taxable_amount) * (Number(gst) / 100);

    var tax_amount = Number(taxable_amount) * (Number(gst) / 100);
    currentRow.find('input[name^="tax_amount"]').val(tax_amount);

    var total = parseInt(taxable_amount) + parseInt(tax_amount);
    currentRow.find('input[name^="total"]').val(total);

    var rate = parseInt(total) / parseInt(quantity);

    currentRow.find('input[name^="rate"]').val(rate);
    var total = +currentRow.find('input[name^="total"]').val();
    // $('#subtotal').val(total);
    var sum = 0;
    $('.total').each(function() {
      sum += Number($(this).val());
    });
    $('#subtotal').val(sum);
    $('#final_total').val(sum);

    var sub_text = $('#subtotal').val();
    var sub_total = Number(sub_text);
    $("#final_total").val(sub_total);

    var tot_commi = 0;
    $('.tax_amount').each(function() {
      tot_commi += Number($(this).val());
    });
    $('#total_tax_amount').val(tot_commi);
    var tot_commi = 0;
    $('.taxable_amount').each(function() {
      tot_commi += Number($(this).val());
    });
    $('#total_taxable_amount').val(tot_commi);
  });

  $('form').on("keyup", 'input[name="discount"]', function(argument) {
  

    var disc = $(this).val();
    var sub_text = $('#subtotal').val();


    var tax_percent = $('#gst_rate').val();
    var disc_amount = Number(sub_text) * (Number(disc) / 100);
    var sub_total = Number(sub_text) - Number(disc_amount);

    var tax_amount = Number(sub_total) * (Number(tax_percent) / 100);
    var taxable_amount = Number(sub_total) - Number(tax_amount);
    $("#total_tax_amount").val(tax_amount);
    $("#total_taxable_amount").val(taxable_amount);

    var sub_total1 = Number(sub_total) - Number(tax_amount);
    $("#final_total").val(sub_total1);
  });

  $('form').on("keyup", 'input[name="gst_rate"]', function() {
    var tax_percent = $(this).val();
    var sub_total = parseFloat($('#subtotal').val());
    var discount = parseFloat($('#discount').val());

    // Calculate discount amount
    var discount_amount = sub_total * (discount / 100);

    // Calculate taxable amount after discount
    var taxable_amount = sub_total - discount_amount;

    // Calculate tax amount based on taxable amount and GST rate
    var tax_amount = taxable_amount * (tax_percent / 100);

    // Update tax amount field
    $("#total_tax_amount").val(tax_amount.toFixed(2));

    // Calculate final total including tax
    var final_total = taxable_amount + tax_amount;

    // Update final total field
    $("#final_total").val(final_total.toFixed(2));
  });


  $('div.mydiv').on("change", 'select[name^="product_id"]', function(event) {
    var drop_services = $(this).val();
    var cnt = 0;
    $(".product_id").each(function() {
      if (drop_services == $(this).val()) {
        cnt++;
      }
    });
    if (cnt >= 2) {
      alert('Product already exists');
      return false;
    }
    var drop_services = $(this).val();
    var currentRow = $(this).closest('.subdiv');
    //console.log(currentRow);


    $.ajax({
      type: "POST",
      dataType: "json",
      url: 'ajax_product.php',
      data: {
        drop_services: drop_services
      },
      success: function(data) {
        currentRow.find('input[name^="aquantity"]').val(data['product']['openning_stock']);
        currentRow.find('input[name^="quantity"]').val(1);

        currentRow.find('input[name^="sale_price"]').val(data['product']['unit_price']);

        var quantity = currentRow.find('input[name^="quantity"]').val();

        var total = data['product']['unit_price'];
        currentRow.find('input[name^="total"]').val(total);

        var rate = parseInt(total) / parseInt(quantity);

        currentRow.find('input[name^="rate"]').val(rate);

        //var total=+currentRow.find('input[name^="total"]').val(total);
        // $('#subtotal').val(total);
        var sum = 0;
        $('.total').each(function() {
          if ($(this).val() != '') {
            sum += parseInt($(this).val());
          }

        });

        var sub = $('#subtotal').val(sum);
        var fsub = $('#final_total').val(sum);

        var tot_commi = 0;
        $('.tax_amount').each(function() {
          tot_commi += Number($(this).val());
        });
        $('#total_tax_amount').val(tot_commi);
        var tot_commi = 0;
        $('.taxable_amount').each(function() {
          tot_commi += Number($(this).val());
        });
        $('#total_taxable_amount').val(tot_commi);
      }
    });

  });

  $('div.mydiv').on("change", 'select[name^="p_group_name"]', function(event) {
    var currentRow = $(this).closest('.subdiv');
    //console.log(currentRow);
    var group_id = $(this).val();
    currentRow.find('select[name^="product_id"]').select2();
    currentRow.find('select[name^="product_id"]').html('<option value="" >Select one </option>');
    $.ajax({
      type: "POST",
      dataType: "json",
      url: 'search_product.php',
      data: {
        group_id: group_id
      },
      success: function(data) {
        for (var i = 0; i < data['products'].length; i++) {
          var p_id = data['products'][i][0];
          var p_name = data['products'][i][2];
          currentRow.find('select[name^="product_id"]').append('<option value="' + p_id + '" > ' + p_name + '</option>');
        }
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    $(".select2").select2();
  });
</script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
  .error {
    color: red !important;

  }
</style>
<script src="../assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>
  function addBrand() {
    jQuery.validator.addMethod("alphanumeric", function(value, element) {
      // Check if the value is empty
      if (value.trim() === "") {
        return false;
      }
      // Check if the value contains at least one alphabet character
      if (!/[a-zA-Z]/.test(value)) {
        return false;
      }
      // Check if the value contains only alphanumeric characters, spaces, and allowed special characters
      return /^[a-zA-Z0-9\s!@#$%^&*()_-]+$/.test(value);
    }, "Please enter alphanumeric characters with at least one alphabet character.");

    jQuery.validator.addMethod("lettersonly", function(value, element) {
      // Check if the value is empty
      if (value.trim() === "") {
        return false;
      }
      return /^[a-zA-Z\s]*$/.test(value);
    }, "Please enter alphabet characters only");

    $.validator.addMethod("noDigits", function(value, element) {
      return this.optional(element) || !/\d/.test(value);
    }, "Please enter a without digits.");



    jQuery.validator.addMethod("noSpacesOnly", function(value, element) {
      // Check if the input contains only spaces
      return value.trim() !== '';
    }, "Please enter a non-empty value");

    $('#add_brand').validate({
      rules: {
        s_name: {
          required: true,
          noSpacesOnly: true,
          alphanumeric: true,
          noDigits: true

        },
        s_no: {
          minlength: 10,
          maxlength: 10,
          digits: true
        },
        email: {
          required: true,
          noSpacesOnly: true
        },
        address: {
          required: true,
          noSpacesOnly: true,
          alphanumeric: true,
          noDigits: true

        },
        quantity: {
          required: true,
          noSpacesOnly: true,
          digits: true
        }

      },
      messages: {
        s_name: {
          required: "Please enter a Name.",
          pattern: "Only alphanumeric characters are allowed.",
          alphanumeric: "Only alphanumeric characters are allowed."
        },


        email: {
          required: "Please enter email.",

        },
        s_no: {
          required: "Please enter Mobile Number.",

        },
        address: {
          required: "Please enter a Address.",
          pattern: "Only alphanumeric characters are allowed.",
          alphanumeric: "Only alphanumeric characters are allowed."
        },
        quantity: {
          required: "Please enter quantity.",


        }

      },
    });
  };
</script>
</body>

</html>