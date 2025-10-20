<?php include('include/head.php'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php include('include/header.php'); ?>
<?php include('include/sidebar.php'); ?>


<div class="dashboard-wrapper">
  <div class="container-fluid  dashboard-content">
    <div class="row">
      <!-- ============================================================== -->
      <!-- validation form -->
      <!-- ============================================================== -->
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <h5 class="card-header">Add Invoice</h5>
          <div class="card-body">
            <form class="form-horizontal auto" action="operation/order.php" method="post" enctype="multipart/form-data" id="add_brand">
              <div class="form-row">
                  
                  
                      <div class="form-group row col-md-6">
                                               <label class="col-sm-3 control-label">Customer <br>Name:<span class="text-danger">*</span></label>
                                                  <div class="col-sm-9">
                                                    <select type="text" class="form-control js-example-basic-single" placeholder=""  name="customer_name" onChange="Cust(this);" id="customer" required>
                                                     <option value="">--Select customer--</option>
                                                    <?php
                                                    $sql = "SELECT * FROM tbl_customer";
                                                    $statement = $conn->prepare($sql);
                                                    $statement->execute();
                                                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>  
                                                        <option value="<?php echo $row['cust_id'];?>"><?php echo $row['cust_name'];?></option>
                                                   <?php } ?>
                                                    
                                                </select>
                                                <a   data-toggle="modal" data-target="#exampleModal">
 Add New Customer
</a>
                                                </div>
                                                </div>

                   <input type="hidden" name="customer_id" class="form-control " id="name"  required>
                  
                <!--<div class="form-group row col-md-6">-->
                <!--  <label class="col-sm-3 control-label">Customer Name:</label>-->
                <!--  <div class="col-sm-9">-->


                <!--    <input type="text" name="customer_id" class="form-control" data-provide="" placeholder="Customer Name" required>-->
                <!--  </div>-->
                <!--</div>-->

                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php $current_date = date('Y-m-d'); ?>
                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label"> Date<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="date" name="build_date" class="form-control " value="<?php echo $current_date; ?>" data-provide="datepicker" required>
                  </div>
                </div>

                &nbsp;&nbsp;&nbsp;&nbsp;
                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Due Date<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="date" name="due_date" class="form-control " data-provide="datepicker" required>
                  </div>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;

                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Customer <br>No: <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" id="no" name="customer_no" class="form-control " placeholder="Customer No" minlength="1" maxlength="10" pattern="^[0][1-9]\d{9}$|^[1-9]\d{9}$" required title="Enter Valid Mobile No">


                  </div>
                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Invoice No:<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <?php $user = "select count(*) as cnt from tbl_invoice";
                    $statement = $conn->prepare($user);
                    $statement->execute();
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    $new = $row['cnt'] + 1;
                    ?>
                    <input type="text" name="inv_no" value="<?php echo $new; ?>" class="form-control" required>
                  </div>
                </div>

                &nbsp;&nbsp;&nbsp;&nbsp;

                <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label"> Email:<span class="text-danger">*</span> </label>
                  <div class="col-sm-9">
                    <input type="email" name="c_email" id="email" class="form-control " placeholder="Customer Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >

                  </div>
                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                
                
                
   <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label"> Address:<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="address" required="" name="c_address" style="height:70px;" placeholder="Customer Address"></textarea>
                  </div>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;
                 <div class="form-group row col-md-6">
                                               <label class="col-sm-3 control-label">Salesmen <br>Name:<span class="text-danger">*</span></label>
                                                  <div class="col-sm-9">
                                                    <select type="text" class="form-control js-example-basic-single" placeholder=""  name="user" required>
                                                     <option value="">--Select Salesmen--</option>
                                                    <?php
                                                    $sql = "SELECT * FROM tbl_admin where role_id != 0 and delete_status = 0 ";
                                                    $statement = $conn->prepare($sql);
                                                    $statement->execute();
                                                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>  
                                                        <option value="<?php echo $row['id'];?>"><?php echo $row['fname']." ".$row['lname'];?></option>
                                                   <?php } ?>
                                                    
                                                </select>
                                              
                                                </div>
                                                </div>
                
                
 
        <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label"> Barcode:<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input class="form-control" id="barcode"  name="barcode">
                     <span style="color:red;">Scan Barcode Here</span>
                  </div>
                </div>

     &nbsp;&nbsp;&nbsp;&nbsp;
          <div class="form-group row col-md-6">
                  <label class="col-sm-3 control-label">Product/Service<br> Code:<span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <input class="form-control" id="barcode123"  name="barcodeid">
                   <span style="color:red;">Enter Product/Service code</span>
                  </div>
                </div> 
          
          
          
          


              </div>

              <div class="form-group row">
                <div class="col-sm-1">
                  Sr no.
                </div>

                <div class="col-sm-4">
                  Select Product/Service
                </div>

                <div class="col-sm-2">
                  Quantity
                </div>
            
                <div class="col-sm-1">
                  Rate
                </div>
          
                <div class="col-sm-2">
                  Total
                </div>
                <div class="col-sm-1">
                  Action
                </div>

              </div>
              <div class="mydiv">
                <div class="form-group row control-group after-add-more subdiv">
                  <div class="col-sm-1 sr_no">1</div>
                  <div class="col-sm-4">
                    <div class="col-sm-12">
                      <select name="product_id[]" class="form-control product_id select2">
                        <option value="">--Select--</option>
                        <?php
     $date = date('Y-m-d');
$sql = "SELECT * FROM tbl_product 
        WHERE delete_status = '0' 
        AND (
            exp != '0' 
            OR (exp = '0' AND exp_date != '0000-00-00' AND exp_date > '$date')
        )
        ORDER BY id DESC";
    
                         $statement = $conn->prepare($sql);
    // $statement->bindParam(':date', $date);
    $statement->execute();
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                          <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
 <input type="hidden" class="form-control" id="exp"  name="exp[]" placeholder="Qty" >
                  <div class="col-sm-2">
<input type="text" class="form-control" id="quantity" name="quantity[]" placeholder="Qty">
                      <input type="hidden" class="form-control" id="aquantity" name="aquantity[]" placeholder="Qty" readonly="">
  <input type="hidden" class="form-control" id="min_stock" name="min_stock[]" placeholder="Qty" readonly="">
  
  
    <input type="hidden" class="form-control" id="min_stock" name="min_stock[]" placeholder="Qty" readonly="">
     
</div>

                  <div class="col-sm-1">
                    <input type="text" class="form-control" id="rate" name="rate[]" placeholder="Rate">
                  </div>

                  <!--<div class="col-sm-2">-->
                  <!--  <input type="text" class="form-control" id="gst" name="gst[]" placeholder="GST">-->
                  <!--</div>-->
                  <div class="col-sm-2">
                    <input type="text" class="form-control total" id="total" name="total[]" placeholder="Total" readonly="">
                  </div>

                  <div class="col-sm-1">
                    <button class="btn btn-success add-more" type="button"><i class="fa fa-plus"></i></button>
                  </div>
                </div>

              </div>



              <!-- <div class="form-group row control-group">
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
              </div> -->

              <input type="hidden" name="subtotal" id="subtotal" class="form-control" placeholder="Subtotal" readonly="">

              <div class="form-group row">
                <label class="col-sm-8 control-label"> Final Total</label>
                <div class="col-sm-3">
                  <input type="text" name="final_total" id="final_total" class="form-control" placeholder="Total" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-8 control-label"> Advance Amount</label>
                <div class="col-sm-3">
                  <input type="text" name="advance_total" id="advance_total" onblur="myFunction()" class="form-control" required>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-8 control-label"> Due Amount</label>
                <div class="col-sm-3">
                  <input type="text" name="due_total" id="due_total" onblur="myFunction()" class="form-control" readonly>
                </div>
              </div>




              <div class="form-group row">
                <label class="col-sm-8 control-label">Payment Method</label>
                <div class="col-sm-3">
                  <select name="ptype" class="form-control select3">
  <option value="1">CASH</option>
  <option value="2">ONLINE</option>
  <option value="3">CHEQUE</option>
  <option value="4">DEBIT CARD</option>
  <option value="5">CREDIT CARD</option>
  <option value="6">UPI</option>
  <option value="7">NET BANKING</option>
  <option value="8">PAYTM</option>
  <option value="9">GOOGLE PAY</option>
  <option value="10">PHONEPE</option>
  <option value="11">BANK TRANSFER</option>
</select>
                </div>


            <div class="col-md-12">
                 <button type="submit" name="btn_save" class="btn btn-primary btn-flat m-b-30 m-t-30" id="submit_check" onclick="addBrand()">Submit</button>
            </div>
               
                <p id="GFG_DOWN" style="color: green;">


                <div class="copy hide" style="display:none;">
                  <div class="form-group control-group row subdiv">
                    <div class="col-sm-1 sr_no"></div>
                    <div class="col-sm-4">
                      <div class="col-sm-12">
                        <select name="product_id[]" class="form-control product_id" required>
                          <option value="">--Select Product--</option>
                          <?php
  $date = date('Y-m-d');
$sql = "SELECT * FROM tbl_product 
        WHERE delete_status = '0' 
        AND (
            exp != '0' 
            OR (exp = '0' AND exp_date != '0000-00-00' AND exp_date > '$date')
        )
        ORDER BY id DESC";
    
                         $statement = $conn->prepare($sql);

    $statement->execute();
                          while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
 <input type="hidden" class="form-control" id="exp"  name="exp[]" >
                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="quantity" name="quantity[]" placeholder="Qty">
                      <input type="hidden" class="form-control" id="aquantity" name="aquantity[]" placeholder="Qty" readonly="">
  <input type="hidden" class="form-control" id="min_stock" name="min_stock[]" placeholder="Qty" readonly="">
                    </div>

                    <div class="col-sm-1">
                      <input type="text" class="form-control" id="rate" name="rate[]" placeholder="Rate" required>
                    </div>
                  <!--   <div class="col-sm-2">-->
                  <!--  <input type="text" class="form-control" id="gst" name="gst[]" placeholder="GST">-->
                  <!--</div>-->
                    <div class="col-sm-2">
                      <input type="text" class="form-control total" id="total" name="total[]" placeholder="Total" readonly="">
                    </div>
                    <div class="col-sm-1">
                      <button class="btn btn-danger remove" type="button"><i class="fa fa-minus"></i></button>
                    </div>
                  </div>
                </div>


             

            </form>

          </div>
        </div>

      </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form-horizontal" action="operation/customer.php" id="validatecustomer" method="post" enctype="multipart/form-data" autocomplete="OFF">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
                                           <div class="form-row">
                              <div class="form-group col-md-6">
                                                <label class=" control-label">Customer Name:<span class="text-danger">*</span></label>
                                              
                                                    

                                                   <input type="text" name="custname" class="form-control" data-provide=""  placeholder="Customer Name" required>
                                        </div>

                                     
                                        <div class="form-group col-md-6">
                                                <label class="control-label">Customer Mobile No:<span class="text-danger">*</span> </label>
                                        
                                                    <input type="text" name="customer_mobno" class="form-control "  placeholder="Customer No" minlength="10" maxlength="10" pattern="^[0][1-9]\d{9}$|^[1-9]\d{9}$" required>
                                        </div>
                    

                                        <div class="form-group col-md-6">
                                                <label class="control-label">Customer Email: <span class="text-danger">*</span></label>
                                                    <input type="text" name="c_email" class="form-control "  placeholder="Customer Email"  >
                                                   
                                        </div>
                                       
                                        <div class="form-group col-md-6">
                                                <label class="control-label">GST No.:<span class="text-danger">*</span></label>
                                                  <input type="text" name="gstin" class="form-control "  placeholder="GST No."  >
                                        </div>

                                        <div class="form-group col-md-6">
                                                <label class="control-label">Customer Address:<span class="text-danger">*</span></label>
                                                 <textarea class="form-control" required name="c_address" style="height:70px;" placeholder="Customer Address"></textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                                <label class="control-label">Customer State: <span class="text-danger">*</span></label>
                                                    
<select id="states" class="form-control " name="state" required>
  <option value="">--Select State--</option>
  <?php 

  $sql = "SELECT * FROM tbl_states ";
// print_r($sql);exit;
                
 $statement = $conn->prepare($sql);
 $statement->execute();

$rec=  $statement->fetchAll();                                                           
                                                     
   foreach($rec as $state )
   { ?>
                        <option value="<?php echo $state['id']; ?>" <?php if($state['id']=='22'){echo 'selected'; } ?> ><?php echo $state['name']; ?></option>
                    <?php } ?>
</select>

                                                   
                                        </div>    


                                    </div>
                              
                                 

            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="btn_save2" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
    <?php include('include/footer.php'); ?>
  </div>

</div>
 <script>

function Cust(eve) {

    var val=$(eve).val();
     var current=$(eve).closest('.auto');
     
 $.ajax({ 

type: "POST",

url: "ajax_represent.php",

data: "id="+val,
dataType:'JSON',
// 
success: function(response){
//   alert(response['display1'][0].cust_address);
 $(current).find('#name').val(response['display1'][0].cust_name);
    $(current).find('#no').val(response['display1'][0].cust_mob);
$(current).find('#email').val(response['display1'][0].cust_email);
$(current).find('#address').val(response['display1'][0].cust_address);
    
 

 }

});   

}
</script>
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
  $('#class_id').change(function() {
    $("#subject_id").val('');
    $("#subject_id").children('option').hide();
    var class_id = $(this).val();
    $("#subject_id").children("option[data-id=" + class_id + "]").show();

  });
</script>


<!--date pickert-->
<script>
  $(function() {
    $(".datepicker").datepicker({
      format: 'dd/mm/yyyy'
    });
  });
</script>


<!--++ script-->
<script type="text/javascript">
  $(".add-more").on('click', function() {

    var html = $(".copy").html();
    $(".after-add-more").after(html);
    $(".after-add-more").next().find('select[name^="product_id"]').select2();
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
</script>

<!--++ script-->
<script type="text/javascript">
  $(".add-more1").on('click', function() {

    var html = $(".copy1").html();
    $(".after-add-more1").after(html);
    $(".after-add-more1").next().find('select[name^="service_id"]').select2();
    show_no();
  });

  $("body").on("click", ".remove1", function() {
    $(this).parents(".control-group1").remove();
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



<script type="text/javascript">
 

$('div.mydiv').on("keyup", 'input[name^="quantity"]', function(event) {
    var currentRow = $(this).closest('.subdiv');
    var quantityInput = currentRow.find('input[name^="quantity"]');
    var availableStock = parseInt(currentRow.find('input[name^="aquantity"]').val()) || 0; // Available stock
    var minStock = parseInt(currentRow.find('input[name^="min_stock"]').val()) || 1; // Min stock (default 1)
    var quantity = parseInt(quantityInput.val()) || 0; // Default to 0 if empty
  var exp = parseInt(currentRow.find('input[name^="exp"]').val());
  // Min stock (default 1)
    // **Check for quantity exceeding stock**
    
    
    if(exp=='0')
    {
    if (quantity > availableStock) {
        alert('Not Enter Value Greater than Stock - ' + availableStock);
        quantityInput.val(availableStock); // Reset to max available stock
        quantity = availableStock;
    }

    // **Check for quantity below minimum stock**
    if (availableStock <= minStock) {
        alert('Product is at low stock. Minimum allowed: ' + minStock);
        quantityInput.val(minStock); // Reset to minimum stock
        quantity = minStock;
    }
}
    // **Get unit price**
    var rate = parseFloat(currentRow.find('input[name^="rate"]').val()) || 0;

    // **Calculate and update total**
    var total = (quantity * rate).toFixed(2);
    currentRow.find('input[name^="total"]').val(total);

    // **Recalculate subtotal**
    var sum = 0;
    $('.total').each(function() {
        sum += parseFloat($(this).val()) || 0;
    });

    $('#subtotal').val(sum.toFixed(2));
    $('#final_total').val(sum.toFixed(2));
 $('#due_total').val(sum.toFixed(2));
    // **Update tax amounts if applicable**
    var totalTaxAmount = 0;
    $('.tax_amount').each(function() {
        totalTaxAmount += parseFloat($(this).val()) || 0;
    });
    $('#total_tax_amount').val(totalTaxAmount.toFixed(2));

    var totalTaxableAmount = 0;
    $('.taxable_amount').each(function() {
        totalTaxableAmount += parseFloat($(this).val()) || 0;
    });
    $('#total_taxable_amount').val(totalTaxableAmount.toFixed(2));
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
        //   alert(data['unit']['un']);
        //currentRow.find('input[name^="quantity"]').val(1);
        currentRow.find('input[name^="aquantity"]').val(data['product']['openning_stock']);
       currentRow.find('input[name^="min_stock"]').val(data['product']['min_stock']);
        currentRow.find('input[name^="quantity"]').val(0);
            currentRow.find('input[name^="exp"]').val(data['product']['exp']);
            
            if(exp==0)
            {
        currentRow.find('input[name^="quantity"]').attr('max', data['product']['openning_stock']);
}
        currentRow.find('input[name^="sale_price"]').val(data['product']['selling_gst']);
        currentRow.find('input[name^="unit"]').val(data['unit']['un']);
        var quantity = currentRow.find('input[name^="quantity"]').val();
        var total1 = data['product']['selling_gst'];
var gst=data['product']['gst'];
var gst_amt= (parseInt(total1)*parseInt(gst))/100;
        var total = parseInt(total1);
        currentRow.find('input[name^="total"]').val(total);

        var rate = parseInt(total) / parseInt(quantity);
        //currentRow.find('input[name^="rate"]').val(rate);
        var rate = data['product']['selling_gst'];
 currentRow.find('input[name^="rate"]').val(rate);
currentRow.find('input[name^="gst"]').val(gst);
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



  $('div.mydiv').on("change", 'select[name^="service_id"]', function(event) {
    var drop_services22 = $(this).val();
    var cnt = 0;
    $(".service_id").each(function() {
      if (drop_services22 == $(this).val()) {
        cnt++;
      }
    });


    var drop_services22 = $(this).val();
    var currentRow = $(this).closest('.subdiv');
    //console.log(currentRow);


    $.ajax({
      type: "POST",
      dataType: "json",
      url: 'ajax_product.php',
      data: {
        drop_services22: drop_services22
      },
      success: function(data) {
        //currentRow.find('input[name^="quantity"]').val(1);



        // currentRow.find('input[name^="aquantity"]').val(data['product']['openning_stock']);

        // currentRow.find('input[name^="quantity"]').val(0);
        // currentRow.find('input[name^="quantity"]').attr('max', data['product']['openning_stock']);

        currentRow.find('input[name^="sale_price"]').val(data['product']['selling_gst']);
        var quantity = currentRow.find('input[name^="quantity2"]').val();

        var total1 = data['product']['selling_gst'];
        currentRow.find('input[name^="total2"]').val(total);
var gst=data['product']['gst'];
var gst_amt= (parseInt(total1)*parseInt(gst))/100;
        var total = parseInt(total1)+parseInt(gst_amt);
        currentRow.find('input[name^="total2"]').val(total);


        var rate = parseInt(total) / parseInt(quantity);
        //currentRow.find('input[name^="rate"]').val(rate);
        var rate = data['product']['selling_gst'];
currentRow.find('input[name^="gst2"]').val(gst);

        currentRow.find('input[name^="rate2"]').val(rate);

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




</script>
<script>
  $(document).ready(function() {
    $(".select2").select2();
  });
</script>
<script>
  $(document).ready(function() {
    $(".select3").select2();
  });
</script>








<style>
  .error {
    color: red !important;

  }
</style>
<script src="../assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>
  function myFunction() {
    var x = document.getElementById("final_total");
    var y = document.getElementById("advance_total");
    var z = document.getElementById("due_total");

    var finalTotal = parseFloat(x.value) || 0;
    var advanceTotal = parseFloat(y.value) || 0;

    // Set max attribute dynamically
    y.setAttribute("max", finalTotal);

    if (advanceTotal > finalTotal) {
      y.value = finalTotal; // Restrict to max allowable value
    }

    z.value = finalTotal - parseFloat(y.value);
  }

  document.getElementById("advance_total").addEventListener("input", function () {
    var finalTotal = parseFloat(document.getElementById("final_total").value) || 0;
    var advanceTotal = parseFloat(this.value) || 0;

    if (advanceTotal > finalTotal) {
      this.value = finalTotal; // Stop entry beyond final total
    }
  });
</script>




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
        customer_id: {
          required: true,
          noSpacesOnly: true,
          noDigits: true

        },
        customer_no: {
          minlength: 10,
          maxlength: 10,
          digits: true
        },
        email: {
          required: true,
          noSpacesOnly: true
        },
        c_address: {
          required: true,
          noSpacesOnly: true

        }

      },
      messages: {
        customer_id: {
          required: "Please enter a first name.",
          pattern: "Only alphanumeric characters are allowed.",
          alphanumeric: "Only alphanumeric characters are allowed."
        },


        email: {
          required: "Please enter email.",

        },
        customer_no: {
          required: "Please enter Mobile Number.",

        },
        c_address: {
          required: "Please enter a Address.",
          pattern: "Only alphanumeric characters are allowed.",
          alphanumeric: "Only alphanumeric characters are allowed."
        }

      },
    });
  };
</script>

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
   $(document).ready(function () {
    var orderList = []; // Array to hold ordered products

    $('#barcode').on('input', function() {
        var inputText = $(this).val().trim();
        var parts = inputText.split('-');
        var barcode = parts.length > 1 ? parts[parts.length - 1] : inputText; // Get the last part or full input if no '-'

        // Make an AJAX request to fetch product details based on barcode
        $.ajax({
            type: 'POST',
            url: 'fetch_product_details.php', // Adjust the URL to your actual server-side script
            data: { barcode: barcode },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    var existingProduct = orderList.find(item => item.id === response.product_id);



                    if (existingProduct) {
                        existingProduct.qty++;

                        if (existingProduct.qty > response.openning_stock) {
                            alert('Entered quantity exceeds available stock.');
                            existingProduct.qty--;
                        } else {
                            updateOrderListRow(existingProduct);
                        }
                    }  else {
                        var selectedProduct = {
                            id: response.product_id,
                            pid: response.pid,
                            name: response.product_name,
                            unitPrice: parseFloat(response.price),
                            qty: 1, // Default quantity should be 1
                            gst: response.gst || 0,
                            openning_stock: response.openning_stock,
                            min_stock: response.min_stock || 0,
                              exp:response.exp
                        };

                      
                            appendNewOrderListRow(selectedProduct);
                            orderList.push(selectedProduct);
                      
                    }

                    $('#barcode').val('');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    function appendNewOrderListRow(product) {
        var newRowHtml = `
            <div class="form-group control-group row subdiv" data-product-id="${product.id}">
                <div class="col-sm-1 sr_no"></div>
                <div class="col-sm-4">
                    <input type="hidden" name="product_id[]" value="${product.pid}">${product.name}
                </div>

                <div class="col-sm-2">
                    <input type="number" class="form-control quantity" name="quantity[]" value="${product.qty}" min="1">
                </div>

                <div class="col-sm-1">
                    <input type="text" class="form-control rate" name="rate[]" value="${product.unitPrice.toFixed(2)}" readonly>
                </div>

       
   <input type="hidden" class="form-control exp" name="exp[]" value="${product.exp}" readonly>
               

                <div class="col-sm-2">
                    <input type="text" class="form-control total" name="total[]" value="${(product.qty * product.unitPrice).toFixed(2)}" readonly>
                </div>
                
           
                    <input type="hidden" class="form-control aquantity" name="aquantity[]" value="${product.openning_stock}" readonly>
              

             
                    <input type="hidden" class="form-control min_stock" name="min_stock[]" value="${product.min_stock}" readonly>
               

                <div class="col-sm-1">
                    <button class="btn btn-danger remove btn-sm" type="button"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        `;
        $('.mydiv').append(newRowHtml);
    }

    function updateOrderListRow(product) {
        var productRow = $('.mydiv').find(`[data-product-id="${product.id}"]`);
        
        if (productRow.length) {
            var quantityInput = productRow.find('.quantity');
            var totalInput = productRow.find('.total');

            quantityInput.val(product.qty);
            totalInput.val((product.qty * product.unitPrice).toFixed(2));
        }
    }

    $(document).on("click", ".remove", function () {
        var productId = $(this).closest(".subdiv").data("product-id");
        orderList = orderList.filter(item => item.id !== productId);
        $(this).closest(".subdiv").remove();
    });
});
</script>




<script>
   $(document).ready(function () {
    var orderList = []; // Array to hold ordered products

    $('#barcode123').on('blur', function() {
        var inputText = $(this).val().trim();
        var parts = inputText.split('-');
        var barcode = parts.length > 1 ? parts[parts.length - 1] : inputText; // Get the last part or full input if no '-'

        // Make an AJAX request to fetch product details based on barcode
        $.ajax({
            type: 'POST',
            url: 'fetch_product_details.php', // Adjust the URL to your actual server-side script
            data: { barcode: barcode },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    var existingProduct = orderList.find(item => item.id === response.product_id);

                    if (existingProduct) {
                        existingProduct.qty++;

                        if (existingProduct.qty > response.openning_stock) {
                            alert('Entered quantity exceeds available stock.');
                            existingProduct.qty--;
                        } else {
                            updateOrderListRow(existingProduct);
                        }
                    } else {
                        var selectedProduct = {
                            id: response.product_id,
                            pid: response.pid,
                            name: response.product_name,
                            unitPrice: parseFloat(response.price),
                            qty: 1, // Default quantity should be 1
                            gst: response.gst || 0,
                            openning_stock: response.openning_stock,
                            min_stock: response.min_stock || 0,
                               exp:response.exp
                        };

                 
                            appendNewOrderListRow(selectedProduct);
                            orderList.push(selectedProduct);
                      
                    }

                    $('#barcode123').val('');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    function appendNewOrderListRow(product) {
        var newRowHtml = `
            <div class="form-group control-group row subdiv" data-product-id="${product.id}">
                <div class="col-sm-1 sr_no"></div>
                <div class="col-sm-4">
                    <input type="hidden" name="product_id[]" value="${product.pid}">${product.name}
                </div>

                <div class="col-sm-2">
                    <input type="number" class="form-control quantity" name="quantity[]" value="${product.qty}" min="1">
                </div>

                <div class="col-sm-1">
                    <input type="text" class="form-control rate" name="rate[]" value="${product.unitPrice.toFixed(2)}" readonly>
                </div>

        
                <div class="col-sm-2">
                    <input type="text" class="form-control total" name="total[]" value="${(product.qty * product.unitPrice).toFixed(2)}" readonly>
                </div>

   <input type="hidden" class="form-control exp" name="exp[]" value="${product.exp}" readonly>
               
    
           
                    <input type="hidden" class="form-control aquantity" name="aquantity[]" value="${product.openning_stock}" readonly>
            

                
                    <input type="hidden" class="form-control min_stock" name="min_stock[]" value="${product.min_stock}" readonly>
          

                

                <div class="col-sm-1">
                    <button class="btn btn-danger remove btn-sm" type="button"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        `;
        $('.mydiv').append(newRowHtml);
    }

    function updateOrderListRow(product) {
        var productRow = $('.mydiv').find(`[data-product-id="${product.id}"]`);
        
        if (productRow.length) {
            var quantityInput = productRow.find('.quantity');
            var totalInput = productRow.find('.total');

            quantityInput.val(product.qty);
            totalInput.val((product.qty * product.unitPrice).toFixed(2));
        }
    }

    $(document).on("click", ".remove", function () {
        var productId = $(this).closest(".subdiv").data("product-id");
        orderList = orderList.filter(item => item.id !== productId);
        $(this).closest(".subdiv").remove();
    });
});
</script>






















</body>

</html>