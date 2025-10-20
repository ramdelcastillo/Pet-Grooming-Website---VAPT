<?php include('include/head.php');?>
<link href="assets/vendor/select2/css/select2.css" rel="stylesheet" />
            <?php include('include/header.php');?>
            <?php include('include/sidebar.php');?>

 <?php 
     $sql = "SELECT * FROM tbl_customer where cust_id='".$_POST['id']."'";
 
       // print_r($sql1);        
 $statement1 = $conn->prepare($sql);
 $statement1->execute();
                                                             
                                                                
     while ($customer = $statement1->fetch(PDO::FETCH_ASSOC)) {
              ?>
            
             
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
                                <h5 class="card-header">Update Customer</h5>
                                <div class="card-body">
                                   <form class="form-horizontal" action="operation/customer.php" method="post" enctype="multipart/form-data">

                                    <input type="hidden" class="form-control" name="id" value="<?php echo $customer['cust_id'];?>">
                                           <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class=" control-label">Customer Name:<span class="text-danger">*</span></label>
                                                   <input type="text" name="custname" class="form-control" data-provide=""  placeholder="Customer Name" value="<?php echo $customer['cust_name'];?>" required>
                                            </div>


                                        <div class="form-group col-md-6">
                                                <label class="control-label">Customer Mobile No:<span class="text-danger">*</span> </label>
                                        
                                                    <input type="text" name="customer_mobno" class="form-control "  placeholder="Customer No" minlength="10" maxlength="10" pattern="^[0][1-9]\d{9}$|^[1-9]\d{9}$" value="<?php echo $customer['cust_mob'];?>" required>
                                        </div>
                                      <div class="form-group col-md-6">
                                                <label class="control-label">GST No.:<span class="text-danger"></span></label>
                                                 <input type="text" class="form-control"  name="gstin"  placeholder="GST No." value="<?php echo $customer['gstin'];?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                                <label class="control-label">Customer Email: <span class="text-danger"></span></label>
                                                    <input type="text" name="c_email" class="form-control "  placeholder="Customer Email" value="<?php echo $customer['cust_email'];?>">
                                                   
                                        </div>
                                        <div class="form-group col-md-6">
                                                <label class="control-label">Customer Address:<span class="text-danger">*</span></label>
                                                 <textarea class="form-control" name="c_address" style="height:70px;">   <?php echo $customer['cust_address'];?></textarea>
                                                
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
                        <option value="<?php echo $state['id']; ?>" <?php if($state['id']==$customer['state']){echo 'selected'; } ?> ><?php echo $state['name']; ?></option>
                    <?php } ?>
 
</select>

                                                   
                                        </div>

                                    </div>
                              
                                   
                           
                         

                             


                             <button type="submit" name="btn_update" class="btn btn-primary btn-flat m-b-30 m-t-30"  >Submit</button>
                                 <p id="GFG_DOWN" style="color: green;">

            </form>
              <?php } ?>
              
              
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


<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $(".select2").select2();
  });
</script>



</body>

</html>
                