

<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>




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
 -->        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid  dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
               <!--  <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Data Tables</h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Tables</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Data Tables</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                --> <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                 <div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                 <a href="Election.php"><button class="btn btn-primary" type="submit" name=""> Add Election</button></a>
                                               </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>SR No</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Ward</th>
                                                <th>Candidate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                                                       
 <?php 
  $sql = "SELECT * FROM tbl_election where status='0' order by id desc";
 
                
 $statement = $conn->prepare($sql);
 $statement->execute();
                                                             
                                                                
     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
 
        extract($row);
         $sql1 = "SELECT * FROM tbl_candidate where id='".$candidate."'";
 
                
 $statement1 = $conn->prepare($sql1);
 $statement1->execute();
    $row1 = $statement1->fetch(PDO::FETCH_ASSOC);                                                         
 
        $no +=1;
                                                            ?>
 
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $title; ?></td>
                                                <td><?= $date; ?></td>
                                                <td><?= $row1['ward']; ?></td>
                                                <td><?= $row1['fname'].$row1['lname']; ?></td>
                                                 <td>


                                                                        
<a href="operation/election.php?id=<?=$id ;?>"><button type="button" class="btn btn-danger cancel-button" id="<?=$id ;?>"><i class="fas fa-trash"></i></button></a>




 <a href="update_election.php?id=<?=$id ;?>"class="btn btn-info" title="Edit Event"><i class="fas fa-edit"></i></a>
   
                                                                        </td>
                                                
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>SR No</th>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th>Ward</th>
                                                <th>Candidate</th>
                                                <th>Action</th>
                                          </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end data table  -->
                    <!-- ============================================================== -->
                </div>
                 </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
                       <?php include('include/footer.php');?>
<!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->

    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="assets/vendor/multi-select/js/jquery.multi-select.js"></script>
    <script src="assets/libs/js/main-js.js"></script>
<script src="assets/libs/js/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="assets/vendor/datatables/js/data-table.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

    
</body>
 
</html>