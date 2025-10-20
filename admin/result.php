 <?php
//error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');

require_once('../assets/constants/fetch-my-info.php');
?>

<?php   include('include/head.php') ?>
<?php   include('include/header.php') ?>
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
                                <a class="nav-link " href="electiondisplay.php"><i class="fas fa-users"></i></i>Election<span class="badge badge-success">6</span></a>
                                  </li>
                                     <li class="nav-item ">
                                <a class="nav-link " href="voterdisplay.php"><i class="fas fa-user-plus"></i></i>Voters<span class="badge badge-success">6</span></a>
                                  </li>
                                   <li class="nav-item ">
                                <a class="nav-link active" href="result.php"><i class="far fa-id-card"></i></i>Result<span class="badge badge-success">6</span></a>
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
 -->
<?php
$sql = "select id from tbl_candidate where voting_count=(select max(voting_count) from tbl_candidate);
";
 
                
 $statement = $conn->prepare($sql);
 $statement->execute();
                                                             
                                                                
     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
 
        extract($row);
        $winner=$id;
                                                               
 
                                                            
 
  }
  $sql = "select id from tbl_candidate where voting_count=(select min(voting_count) from tbl_candidate);
";
 
                
 $statement = $conn->prepare($sql);
 $statement->execute();
                                                             
                                                                
     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
 
        extract($row);
        $losser=$id;
            echo$losser;                                          
 
                                                            
 
  }

  ?>

<!-- <?php $sql = "SELECT * FROM tbl_election where status='0' order by id desc";
 
                
 $statement = $conn->prepare($sql);
 $statement->execute();
                                                             
                                                                
     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
 
        extract($row);
                                                               
 
                                                            
 
  }?>

 -->        <!-- ============================================================== -->
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
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <!--  
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">E-Commerce Dashboard Template</li>
                                        </ol>
                                    </nav>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">
                                                           
                            
                        <div class="row">
                            <?php $sql = "SELECT * FROM tbl_election where status='0' order by id desc";
 
                
 $statement = $conn->prepare($sql);
 $statement->execute();
                                                             
                                                                
     $result_p= $statement->fetchAll();
            foreach($result_p as $row){

        extract($row);
                                                               
 
                                                            
 
  ?>

                            <?php
                                                                   
$sql1 = "SELECT * FROM tbl_candidate where  id='".$candidate."'";
                
  $statement = $conn->prepare($sql1);
                                                 $statement->execute();
                                                             
                                                                
                                   
    
            $result_p= $statement->fetchAll();
            foreach($result_p as $row){



/*                                                                   $word_id=$id;
*/                                                            ?>

                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="row">
                                                                    <h2 class="pageheader-title"><?= $title; ?></h2>
                                                                  </div>

                                <div class="card">
                                    <div class="card-body" >
                                       <img src="../assets/uploadImage/Candidate/<?= $row['image']; ?>" width="195" height="150" value="<?= $image; ?>" readonly/>
                                       <br/><br/>

                                      <input type="text" class="form-control " name="name"  required pattern="^[a-zA-Z]+$" placeholder=" Name" value="<?= $row['fname'].'-'.$row['lname']; ?>" readonly>
                                               <br/>

                                       <input type="text" class="form-control" name="qualification" value="<?= $row['qualification']; ?>" required  required 
placeholder="Qualification" readonly><br/>
<center>
<?php
if($row['id']==$winner)
{?>
<h1 style="background-color:green;color: white;">Winner</h1>
<?php
}
else{?>
    <h1 style="background-color:red;color: white;">Loser</h1>
<?php
}

?>


</center>

                                          </div>
                                    
                                </div>
                            </div>
                            <!-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Affiliate Revenue</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">$12099</h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                            <span><i class="fa fa-fw fa-arrow-up"></i></span><span>5.86%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue2"></div>
                                </div>
                            </div>
                             -->                              <?php } } ?>



                                               </div>
                            <!-- ============================================================== -->
                            <!-- end sales traffice country source  -->
                            <!-- ============================================================== -->
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
                       <?php include('include/footer.php');?><!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
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