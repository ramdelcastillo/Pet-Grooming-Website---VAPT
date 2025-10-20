<?php include('include/head.php');?>
<link href="assets/vendor/select2/css/select2.css" rel="stylesheet" />
            <?php include('include/header.php');?>
            <?php include('include/sidebar.php');?>
             
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
               
               <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                   <div class="row">
                        <!-- ============================================================== -->
                        <!-- validation form -->
                        <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Customer</h5>
                                <div class="card-body">
                                   <form class="form-horizontal" action="operation/customer.php" id="validatecustomer" method="post" enctype="multipart/form-data" autocomplete="OFF">
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
                                                <label class="control-label">Customer Email: <span class="text-danger"></span></label>
                                                    <input type="text" name="c_email" class="form-control "  placeholder="Customer Email"  >
                                                   
                                        </div>
                                       
                                        <div class="form-group col-md-6">
                                                <label class="control-label">GST No.:<span class="text-danger"></span></label>
                                                  <input type="text" name="gstin" class="form-control "  placeholder="GST No."  >
                                        </div>

                                        <div class="form-group col-md-6">
                                                <label class="control-label">Customer Address:<span class="text-danger">*</span></label>
                                                 <textarea class="form-control" required name="c_address" style="height:70px;" placeholder="Customer Address"></textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                                <label class="control-label">Customer State: <span class="text-danger">*</span></label>
                                                    
<select id="states" class="form-control select2" name="state" required>
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
                              
                                 <button type="submit" name="btn_save" onclick="validatecustomer()" class="btn btn-primary btn-flat m-b-30 m-t-30"  >Submit</button>
                                 <p id="GFG_DOWN" style="color: green;">

            </form>
               <?php include('include/footer.php');?>

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


<style>
    .error {
        color: red !important;

    }
</style>
<script src="../assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $(".select2").select2();
  });
</script>



<script>
    function validatecustomer() {
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

        jQuery.validator.addMethod("noSpacesOnly", function(value, element) {
            // Check if the input contains only spaces
            return value.trim() !== '';
        }, "Please enter a non-empty value");

        $('#validatecustomer').validate({
            rules: {
                custname: {
                    required: true,
                    alphanumeric: true,
                    noSpacesOnly: true
                },
                customer_mobno: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                c_email: {
                    required: false,
                    email: true,
                    noSpacesOnly: false
                },
                gstin: {
                    required: false,
                  
                    noSpacesOnly: false
                },
                c_address: {
                    required: true,
                    noSpacesOnly: true
                },
                state: {
                    required: true
                }
            },
            messages: {
                custname: {
                    required: "Please enter a name.",
                    pattern: "Only alphanumeric characters are allowed."
                },
                customer_mobno: {
                    required: "Please Enter Customer Mobile No."
                },
                c_email: {
                    required: "Please Enter valid Email ID."
                },
                gstin: {
                    required: "Please Enter GST No."
                },
                c_address: {
                    required: "Please Enter Customer Address."
                },
                state: {
                    required: "Please Select State."

                }
            },
        });
    };
</script>
                