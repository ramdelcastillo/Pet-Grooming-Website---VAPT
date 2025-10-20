
<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>

<?php
 if(isset($_POST["btn_web"]))
{

   $sql = "UPDATE tbl_email_config SET name=:name,mail_driver_host=:mail_driver,mail_port=:mail_port,mail_username=:mail_username,mail_password=:mail_password,mail_encrypt=:mail_encryption";
   $stmt = $conn->prepare($sql);
   $stmt->bindParam(':name', htmlspecialchars($_POST['name']));
   $stmt->bindParam(':mail_driver', htmlspecialchars($_POST['mail_driver']));
   $stmt->bindParam(':mail_username', htmlspecialchars($_POST['mail_username']));
   $stmt->bindParam(':mail_port', htmlspecialchars($_POST['mail_port']));
   $stmt->bindParam(':mail_password', htmlspecialchars($_POST['mail_password']));
   $stmt->bindParam(':mail_encryption', htmlspecialchars($_POST['mail_encryption']));
   
   $execute = $stmt->execute();
   
  if ($execute === TRUE) {
    //echo "<script>alert(' Record Successfully Updated');</script>";
  
   
      $_SESSION['success']='Record Successfully Updated';
      ?>
      <div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      Success 
    </h1>
    <p>Record Successfully Updated</p>
    <p>
    
     <?php echo "<script>setTimeout(\"location.href = 'manage_email.php';\",2000);</script>"; ?>
    </p>
  </div>
</div>
</div>
 
      <?php 

} else {
   
      //$_SESSION['error']='Something Went Wrong';
}
  ?>
  <?php
}

?>



<?php
$stmt = $conn->prepare("select *from tbl_email_config");
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
extract($row);
  $mail_password = $row['mail_password'];
  $mail_driver = $row['mail_driver_host'];
  $name = $row['name'];
  $mail_port = $row['mail_port'];
  $mail_username = $row['mail_username'];
  $mail_encryption = $row['mail_encrypt'];

}

?> 


            <?php include('include/head.php');?>
            <?php include('include/header.php');?>
            <link rel="stylesheet" href="operation/popup_style.css">
                        <?php include('include/sidebar.php');?>
        
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Email Management </h2>
                            <p class="pageheader-text">Email Management</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                       <!--  <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Forms</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Form Validations</li>
                                  -->   </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
             
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- valifation types -->
                        <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Email Management </h5>
                                <div class="card-body">
                                     <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                                       <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Name</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text"  value="<?php echo $name;?>"  name="name" class="form-control" required pattern="^[a-zA-Z]+$">
                                                 </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Mail Driver Mail Host</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text"  value="<?php echo $mail_driver;?>"  name="mail_driver" class="form-control" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
>
                                              </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Mail Port</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text" value="<?php echo $mail_port;?>"  name="mail_port" class="form-control" pattern="^[0-9]+$" required>
                                               </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Mail Username</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text" value="<?php echo $mail_username;?>"  name="mail_username" class="form-control" required pattern="^[a-zA-Z0-9]+$">
                                                 </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Mail Password</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                               <input type="password"  value="<?php echo $mail_password;?>" name="mail_password" class="form-control" required>
                                              
                                      </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Mail Encryption</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text" value="<?php echo $mail_encryption;?>"  name="mail_encryption" class="form-control">
                                              
                                      </div>
                                        </div>
                                       
                                        <div class="form-group row text-right">
                                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                                <button type="submit" class="btn btn-space btn-primary " type="submit" name="btn_web">Update</button>
                                                <button class="btn btn-space btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end valifation types -->
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
           <?php include('include/footer.php');?>
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
</body>
 
</html>