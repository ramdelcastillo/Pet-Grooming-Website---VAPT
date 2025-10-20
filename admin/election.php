

            <?php include('include/head.php');?>
            <?php include('include/header.php');?>
             <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="index.php"><i class="fa fa-fw fa-user-circle"></i>Dashboard <span class="badge badge-success">6</span></a>
                                  </li>
                                   <li class="nav-item ">
                                <a class="nav-link  " href="candidatedisplay.php"><i class="fas fa-user-plus"></i></i>Candidate<span class="badge badge-success">6</span></a>
                                  </li>
                      

                                  <li class="nav-item ">
                                <a class="nav-link active" href="electiondisplay.php"><i class="fas fa-users"></i></i>Election<span class="badge badge-success">6</span></a>
                                  </li>
                                     <li class="nav-item ">
                                <a class="nav-link " href="voterdisplay.php"><i class="fas fa-user-plus"></i></i>Voters<span class="badge badge-success">6</span></a>
                                  </li>
                                   <li class="nav-item ">
                                <a class="nav-link " href="result.php"><i class="far fa-id-card"></i></i>Result<span class="badge badge-success">6</span></a>
                                  </li>
                      
                      
                      
                                                 <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-sun"></i>Setting</a>
                                <div id="submenu-2" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="manage_website.php"> <span class="badge badge-secondary">Manage Website</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="manage_website.php">Manage Website</a>
                                        </li>
                                       
                                        <li class="nav-item">
                                            <a class="nav-link" href="manage_email.php">Email Management</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="seo_setting.php">SEO Setting</a>
                                        </li>
                                       
                                           </ul>
                                </div>
                            </li>
                             <li class="nav-item ">
                                <a class="nav-link " href="author.php"><i class="fas fa-user"></i></i>About Author<span class="badge badge-success">6</span></a>
                                  </li>
                      
                             <li class="nav-item ">
                                <a class="nav-link " href="../logout.php"><i class="fas fa-lock"></i></i>Logout<span class="badge badge-success">6</span></a>
                                  </li>
                      
                           
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        
<!--                         <?php include('include/sidebar.php');?>
 --><div class="dashboard-wrapper">
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
                                <h5 class="card-header">Election</h5>
                                <div class="card-body">
                                   <form class="form-horizontal" action="operation/election.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Title</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text" required="" placeholder="Title" class="form-control" value=""  name="title" required  >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Date</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="date" class="form-control" name="date" value="" required  placeholder="Date">
                                                 </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Ward </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <select type="text" class="form-control" placeholder="" name="ward"  required="" id="class_id">
                                        <option value="">--Select Ward  --</option>
                                                       <?php

                       
  $sql = "SELECT * FROM tbl_candidate where status='0' ";
 
                
  $statement = $conn->prepare($sql);
                                                 $statement->execute();
                                                             
                                                                
                                                               while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                                                    extract($row);?>
 
                                       
                                                   
                                                    <option value="<?php echo$id;?>" ><?php echo$ward;?></option>
                                                    <?php
                                                }
                                                
?>
                                                       </select>                          </div>
                                        </div>
                                    
                                    
                                       
                                        
                                        
                                         <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Candidate List</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                               <select type="text" class="form-control" placeholder="" name="candidate"  required="" id="subject_id">
                                        <option value="">--Select Candidate  --</option>
                                                       <?php

                       
  $sql = "SELECT * FROM tbl_candidate where status='0' ";
 
                
  $statement = $conn->prepare($sql);
                                                 $statement->execute();
                                                             
                                                                
                                                               while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                                                    extract($row);?>
 
                                       
                                                   
                                                    <option value="<?php echo$id;?>" style="display: none;" data-id="<?php echo$id;?>"><?php echo$fname.$lname;?></option>
                                                    <?php
                                                }
                                                
?>
                                                       </select>                          </div>
                                        </div>
                                    
                                    
                                       
                                        
                                           <!-- <div class="form-row">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                                <label for="validationCustom03">Title</label>
                                                 <input type="text" class="form-control " name="fname"  required pattern="^[a-zA-Z]+$" placeholder="Title">
                                               <div class="invalid-feedback">
                                                </div>
                                            </div>
                                            --> 


                                           
                                             
                                        

                                        <br>
                                        <center>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                <button class="btn btn-primary" type="submit" name="btn_save">Submit</button>
                                            </div>
                                          </center>
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
    <script type="text/javascript">1
 $('#class_id').change(function(){
    $("#subject_id").val('');
    $("#subject_id").children('option').hide();
    var class_id=$(this).val();
    $("#subject_id").children("option[data-id="+class_id+ "]").show();
    
  });
</script>

</body>
 
</html>