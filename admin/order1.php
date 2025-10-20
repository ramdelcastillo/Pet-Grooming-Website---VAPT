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
                                                    <select type="text" class="form-control js-example-basic-single" placeholder=""  name="customer_name" onChange="Cust(this);" id="customer">
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
                  <label class="col-sm-3 control-label">Project <span class="text-danger">*</span></label>
                  <div class="col-sm-9">
                    <select name="project" class="form-control js-example-basic-single2" placeholder="Customer No" minlength="1" maxlength="10"  required title="Enter Valid Mobile No">
                    <option>Select Project</option>

                    <?php $stmt = $conn->prepare("SELECT * FROM `tbl_project` WHERE delete_status='0' ");
                      $stmt->execute();
                      $record = $stmt->fetchAll();

                      foreach ($record as $res) { ?>

                        <option value="<?php echo $res['id'] ?>">
                        <?php echo $res['name'];
                      } ?>
                        </option>
                       </select>

                  </div>
                </div>&nbsp;&nbsp;&nbsp;&nbsp;





              </div>

              <div class="form-group row">
                <div class="col-sm-1">
                  Sr no.
                </div>

                <div class="col-sm-2">
                  Select Product
                </div>

                <div class="col-sm-2">
                  Quantity
                </div>
                 <div class="col-sm-1">
                  Unit
                </div>
                <div class="col-sm-1">
                  Rate
                </div>
                <div class="col-sm-2">
                  GST %
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
                  <div class="col-sm-2">
                    <div class="col-sm-12">
                      <select name="product_id[]" class="form-control product_id select2">
                        <option value="">--Select Product--</option>
                        <?php
                        $sql = "SELECT * FROM tbl_product where delete_status='0' order by id desc";
                        $statement = $conn->prepare($sql);
                        $statement->execute();
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                          <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-2">
  <input type="number" class="form-control" id="quantity1" pattern="^[0-9]+$" name="quantity[]" placeholder="Qty" onblur="GFG_Fun();" min="0">
  <input type="hidden" class="form-control" id="aquantity" name="aquantity[]" placeholder="Qty" readonly="">
</div>
 <div class="col-sm-1">
                    <input type="text" class="form-control" id="unit" name="unit[]" placeholder="Unit" readonly="">
                  </div>
                  <div class="col-sm-1">
                    <input type="text" class="form-control" id="rate" name="rate[]" placeholder="Rate">
                  </div>

                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="gst" name="gst[]" placeholder="GST">
                  </div>
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
                <label class="col-sm-6 control-label"> Final Total</label>
                <div class="col-sm-3">
                  <input type="text" name="final_total" id="final_total" class="form-control" placeholder="Total" readonly="">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-6 control-label"> Advance Amount</label>
                <div class="col-sm-3">
                  <input type="text" name="advance_total" id="advance_total" onblur="myFunction()" class="form-control">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-6 control-label"> Due Amount</label>
                <div class="col-sm-3">
                  <input type="text" name="due_total" id="due_total" onblur="myFunction()" class="form-control">
                </div>
              </div>




              <div class="form-group row">
                <label class="col-sm-6 control-label">Payment Method</label>
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

                <button type="submit" name="btn_save" class="btn btn-primary btn-flat m-b-30 m-t-30" id="submit_check" onclick="addBrand()">Submit</button>
                <p id="GFG_DOWN" style="color: green;">


                <div class="copy hide" style="display:none;">
                  <div class="form-group control-group row subdiv">
                    <div class="col-sm-1 sr_no"></div>
                    <div class="col-sm-2">
                      <div class="col-sm-12">
                        <select name="product_id[]" class="form-control product_id" required>
                          <option value="">--Select Product--</option>
                          <?php
                          $sql = "SELECT * FROM tbl_product where delete_status='0' order by id desc";
                          $statement = $conn->prepare($sql);
                          $statement->execute();
                          while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="quantity" name="quantity[]" placeholder="Qty" pattern="^[0-9]+$" max="">
                      <input type="hidden" class="form-control" id="aquantity" name="aquantity[]" placeholder="Qty" pattern="^[0-9]+$" readonly="">

                    </div>
<div class="col-sm-1">
                    <input type="text" class="form-control" id="unit" name="unit[]" placeholder="Unit" readonly="">
                  </div>
                    <div class="col-sm-1">
                      <input type="text" class="form-control" id="rate" name="rate[]" placeholder="Rate" required>
                    </div>
                     <div class="col-sm-2">
                    <input type="text" class="form-control" id="gst" name="gst[]" placeholder="GST">
                  </div>
                    <div class="col-sm-2">
                      <input type="text" class="form-control total" id="total" name="total[]" placeholder="Total" readonly="">
                    </div>
                    <div class="col-sm-1">
                      <button class="btn btn-danger remove" type="button"><i class="fa fa-minus"></i></button>
                    </div>
                  </div>
                </div>


                <div class="copy1 hide" style="display:none;">
                  <div class="form-group control-group1 row subdiv">
                    <div class="col-sm-1 sr_no"></div>
                    <div class="col-sm-3">
                      <div class="col-sm-12">
                        <select name="service_id[]" class="form-control service_id ">
                          <option value="">--Select Service--</option>
                          <?php
                          $sql = "SELECT * FROM tbl_service where delete_status='0' order by id desc";
                          $statement = $conn->prepare($sql);
                          $statement->execute();
                          while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-1">
                      <input type="number" class="form-control" id="quantity" name="quantity2[]" placeholder="Qty">
                      <!-- <input type="hidden" class="form-control" id="aquantity" name="aquantity2[]" placeholder="Qty" pattern="^[0-9]+$" readonly=""> -->
                    </div>

                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="rate2" name="rate2[]" placeholder="Rate" required>
                    </div>
                    <div class="col-sm-1">
                    <input type="text" class="form-control" id="gst2" name="gst2[]" placeholder="GST">
                  </div>

                    <div class="col-sm-2">
                      <input type="text" class="form-control total" id="total" name="total2[]" placeholder="Total" readonly="">
                    </div>
                    <div class="col-sm-2">
                      <button class="btn btn-danger remove1" type="button"><i class="fa fa-minus"></i></button>
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
  $(document).ready(function() {
    $('div.mydiv').on("keyup", 'input[name^="rate"]', function(event) {
      var currentRow = $(this).closest('.subdiv');
      var quantity = currentRow.find('input[name^="quantity"]').val();
      var x = parseInt(quantity);
      var quantityq = currentRow.find('input[name^="aquantity"]').val();
      var x1 = parseInt(quantityq);
      //alert(x1);
      if (x > x1) {
        alert('Not Enter Value Greather than stock' + '-' + x1);
        location.reload();
      }

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
    var tot_commi = 0;
    $('.taxable_amount').each(function() {
      tot_commi += Number($(this).val());
    });
    $('#total_taxable_amount').val(tot_commi);
  });

  $('div.mydiv').on("keyup", 'input[name^="quantity"]', function(event) {
    var currentRow = $(this).closest('.subdiv');
    var quantity = currentRow.find('input[name^="quantity"]').val();
    var x = parseInt(quantity);
    var quantityq = currentRow.find('input[name^="aquantity"]').val();
    var x1 = parseInt(quantityq);
    //alert(x1);
    if (x > x1) {
      alert('Not Enter Value Greather than stock' + '-' + x1);
      location.reload();
    }

    var sale_price = currentRow.find('input[name^="total"]').val();

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
        //   alert(data['unit']['un']);
        //currentRow.find('input[name^="quantity"]').val(1);
        currentRow.find('input[name^="aquantity"]').val(data['product']['openning_stock']);

        currentRow.find('input[name^="quantity"]').val(0);
        currentRow.find('input[name^="quantity"]').attr('max', data['product']['openning_stock']);

        currentRow.find('input[name^="sale_price"]').val(data['product']['unit_price']);
        currentRow.find('input[name^="unit"]').val(data['unit']['un']);
        var quantity = currentRow.find('input[name^="quantity"]').val();
        var total1 = data['product']['unit_price'];
var gst=data['product']['gst'];
var gst_amt= (parseInt(total1)*parseInt(gst))/100;
        var total = parseInt(total1)+parseInt(gst_amt);
        currentRow.find('input[name^="total"]').val(total);

        var rate = parseInt(total) / parseInt(quantity);
        //currentRow.find('input[name^="rate"]').val(rate);
        var rate = data['product']['unit_price'];
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

        currentRow.find('input[name^="sale_price"]').val(data['product']['unit_price']);
        var quantity = currentRow.find('input[name^="quantity2"]').val();

        var total1 = data['product']['unit_price'];
        currentRow.find('input[name^="total2"]').val(total);
var gst=data['product']['gst'];
var gst_amt= (parseInt(total1)*parseInt(gst))/100;
        var total = parseInt(total1)+parseInt(gst_amt);
        currentRow.find('input[name^="total2"]').val(total);


        var rate = parseInt(total) / parseInt(quantity);
        //currentRow.find('input[name^="rate"]').val(rate);
        var rate = data['product']['unit_price'];
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
<script>
  $(document).ready(function() {
    $(".select3").select2();
  });
</script>





<script type="text/javascript">
  $('#quantity').keyup(function() {
    // alert(0);
    if ($(this).val() > 2) {
      alert("No numbers above 100");
      $(this).val('100');
    }
  });


  function GFG_Fun() {

    var x = document.getElementById("quantity1").value;

    var x1 = document.getElementById("quantity1").maxlength;
    //alert(x1);
    if (x > x1) {

      alert("OUT OF STOCK");
    }
    $(document).ready(function() {
      $('#quantity1').on('keydown keyup change', function() {
        var char = $(this).val();
        var charLength = $(this).val().length;
        // alert(char);
        if (charLength < minLength) {
          $('#warning-message').text('Length is short, minimum ' + minLength + ' required.');
        } else if (charLength > maxLength) {
          $('#warning-message').text('Length is not valid, maximum ' + maxLength + ' allowed.');
          $(this).val(char.substring(0, maxLength));
        } else {
          $('#warning-message').text('');
        }
      });
    });
  }
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
    z.value = x.value - y.value;
    //alert(z.value);
  }
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
</body>

</html>