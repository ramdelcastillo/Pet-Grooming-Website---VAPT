<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>

<?php
 
if(isset($_POST["btn_web"]))
{
  //extract($_POST);
  $target_dir = "../assets/uploadImage/SEO/";
  $website_logo = basename($_FILES["website_image"]["name"]);
  if($_FILES["website_image"]["tmp_name"]!=''){
    $image = $target_dir . basename($_FILES["website_image"]["name"]);
   if (move_uploaded_file($_FILES["website_image"]["tmp_name"], $image)) {
    
       @unlink("../assets/uploadImage/SEO/".$_POST['old_website_image']);
    
    } else {
        //echo "Sorry, there was an error uploading your file.";
    }
  }
  else {
     $website_logo =$_POST['old_website_image'];
  }

   $sql = "UPDATE tbl_seo SET site_meta_ta=:site_meta_ar_tags,site_meta_description=:site_meta_description,og_meta_title=:og_meta_ar_tags,og_meta_description=:og_meta_description,og_meta_site_name=:og_meta_site,og_meta_url=:og_meta_url,image=:website_logo";
   $stmt = $conn->prepare($sql);
   $stmt->bindParam(':site_meta_ar_tags', htmlspecialchars($_POST['site_meta_ar_tags']));
   $stmt->bindParam(':website_logo', htmlspecialchars($website_logo));
   $stmt->bindParam(':site_meta_description', htmlspecialchars($_POST['site_meta_description']));
   $stmt->bindParam(':og_meta_ar_tags', htmlspecialchars($_POST['og_meta_ar_tags']));
   $stmt->bindParam(':og_meta_description', htmlspecialchars($_POST['og_meta_description']));
   $stmt->bindParam(':og_meta_site', htmlspecialchars($_POST['og_meta_site']));
   $stmt->bindParam(':og_meta_url', htmlspecialchars($_POST['og_meta_url']));
   
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
    
     <?php echo "<script>setTimeout(\"location.href = 'seo_setting.php';\",1500);</script>"; ?>
    </p>
  </div>
</div>
</div>
 
      <!-- <script type="text/javascript">
        window.location = "seo_setting.php";
      </script>
       --><?php 

} else {
   
      //$_SESSION['error']='Something Went Wrong';
}
  ?>
  <script>
  //window.location = "sms_config.php";
  </script>
  <?php
}

?>




<?php
$sql="select * from tbl_seo";
$statement = $conn->prepare($sql);
$statement->execute();
                                                             
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
 
             //print_r($row);
  extract($row);
  }

?>


            <?php include('include/head.php');?>
            <link rel="stylesheet" href="operation/popup_style.css">

            <?php include('include/header.php');?>
                                    <?php include('include/sidebar.php');?>

        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">SEO Setting </h2>
                            <p class="pageheader-text">SEO Setting</p>
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
                                <h5 class="card-header">SEO Setting </h5>
                                <div class="card-body">
                                     <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                                       <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Site Meta Tags
</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                              <input type="text" name="site_meta_ar_tags"  class="form-control" data-role="tagsinput" value="<?php echo $site_meta_ta;?>" id="site_meta_ar_tags"? placeholder="Site Meta Tags
" required >
                                                   </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Site Meta Description</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <textarea type="text" value="<?php echo $site_meta_description;?>" name="site_meta_description" class="form-control" required placeholder="Site Meta Description"
                                            ><?php echo $site_meta_description;?></textarea>
                                              </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Og Meta Title
</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                              <input type="text" name="og_meta_ar_tags"  class="form-control" data-role="tagsinput" value="<?php echo $og_meta_title;?>" id="site_meta_ar_tags"? placeholder="Og Meta Title" required="">
                                                   </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Og Meta Description</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <textarea type="text" value="<?php echo $og_meta_description;?>" name="og_meta_description" class="form-control" required placeholder="Og Meta Description"
                                            ><?php echo $og_meta_description;?></textarea>
                                              </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Og Meta Site Name
</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                              <input type="text" name="og_meta_site"  class="form-control" data-role="tagsinput" value="<?php echo $og_meta_site_name;?>" id="site_meta_ar_tags"? placeholder="Og Meta Site Name" required="">
                                                   </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Og Meta URL
</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                              <input type="url" name="og_meta_url"  class="form-control" data-role="tagsinput" value="<?php echo $og_meta_url;?>" id="site_meta_ar_tags"? placeholder="Og Meta URL" required>
                                                   </div>
                                        </div>
                                        
                                       
                                       
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Og Meta Image 
</label>
                                          <?php
                                          // Read the image file and encode it to Base64
                                          $imagePath1 = "../assets/uploadImage/SEO/" . $image; // Path to your image file
                                          $imageData1 = file_get_contents($imagePath1);
                                          $base64Image1 = base64_encode($imageData1);
                                          ?>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                 <image class="profile-img" src="data:image/jpeg;base64,<?php echo $base64Image1; ?>" style="height:35%;width:25%;">
                  <input type="hidden" value="<?=$image?>" name="old_website_image">
                          <input type="file" class="form-control" name="website_image">
                                
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