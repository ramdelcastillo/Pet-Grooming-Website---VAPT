<?php
   //error_reporting(0);
session_start();
   require_once('../assets/constants/config.php');
   require_once('../assets/constants/check-login.php');
   require_once('../assets/constants/fetch-my-info.php');
   
   


$stmt_web = $conn->prepare("SELECT * FROM `tbl_manage_website` ");
 $stmt_web->execute();
$record_website=$stmt_web->fetch();



                  $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id='".$_SESSION['id']."'");
                   $stmt->execute();
                   $admin = $stmt->fetch(PDO::FETCH_ASSOC);
              
                   $stmt = $conn->prepare("SELECT * FROM `tbl_permission_role` WHERE group_id='".$admin['role_id']."'");
                   $stmt->execute();
                   $roles = $stmt->fetchAll(); 
                // print_r($roles);exit;
                   $setroles=array();
                   foreach ($roles as $role) {
                       $stmt = $conn->prepare("SELECT * FROM `tbl_permissions` WHERE id='".$role['permission_id']."'");
                 
                   $stmt->execute();
                   $per = $stmt->fetchAll();
                   array_push($setroles, $per[0]['name']);
                   }
                 
                   $_SESSION['userroles']=$setroles;
                   $userroles=$_SESSION['userroles']; 
                // print_r($userroles);exit;
                   ?>

<div class="nav-left-sidebar sidebar-light">
   <div class="menu-list">
        <a class="navbar-brand" href="index.php">
                
                                <img class="img-fluid" src="../assets/uploadImage/Logo/<?php echo $login_logo; ?>" style="width:200px;height:auto;" alt="Theme-Logo" />
                            </a>
      <nav class="navbar navbar-expand-lg navbar-light">
         <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav flex-column">
               <!-- <li class="nav-divider mt-3">
                  Menu
               </li> -->
               <li class="nav-item mt-1">
                  <a class="nav-link active" href="index.php"><i class="ti ti-smart-home me-2"></i>Dashboard </a>
               </li>
               
                 <?php if (in_array('User Management',$userroles) || ($admin['role_id']==0))
                  { ?>  
               <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-9" aria-controls="submenu-9"><i class="ti ti-user me-2"></i>User Management</a>
                  <div id="submenu-9" class="collapse submenu" style="">
                     <ul class="nav flex-column">
                              <?php if (in_array('View Users',$userroles) || ($admin['role_id']==0))
                         { ?>  
                        <li class="nav-item">
                           <a class="nav-link" href="view_user.php">View User</a>
                        </li>
                        <?php  } ?>
                        
                        
                        <?php if (in_array('View Roles',$userroles) || ($admin['role_id']==0))
                         { ?>  
                        <li class="nav-item">
                           <a class="nav-link" href="view_role.php">View Role</a>
                        </li>
                        <?php  } ?>
                     </ul>
                  </div>
               </li>
               <?php  }  ?>
               
               
               
               
                
                 <?php if (in_array('Customer Management',$userroles) || ($admin['role_id']==0))
                  { ?>  
               <li class="nav-item ">
                  <a class="nav-link  " href="view_customer.php"><i class="ti ti-user-plus me-2"></i>Customer Management</a>
               </li>
<?php  } ?>




  <?php if (in_array('Category',$userroles) || ($admin['role_id']==0))
                  { ?>  
                <li class="nav-item ">
                  <a class="nav-link  " href="category.php"><i class="ti ti-brand-producthunt me-2"></i> Category</a>
               </li>
               <?php  } ?>
              
              
              
                <?php if (in_array('Product/Service Management',$userroles) || ($admin['role_id']==0))
                  { ?>  
               <li class="nav-item ">
                  <a class="nav-link " href="productdisplay.php"><i class="ti ti-list-details me-2"></i>Product/Service</a>
               </li>
               <?php  } ?>
              
              
                    <?php if (in_array('Invoice',$userroles) || ($admin['role_id']==0))
                  { ?>  
               <li class="nav-item ">
                  <a class="nav-link " href="view_order.php"><i class="ti ti-arrows-sort me-2"></i>Invoice</a>
               </li>
              <?php } ?>
              
              
                 <?php if (in_array('Tax',$userroles) || ($admin['role_id']==0))
                  { ?>  
               <li class="nav-item ">
                  <a class="nav-link " href="tax.php"><i class="ti ti-plus me-2"></i>Tax</a>
               </li>
              <?php } ?>
              
              
              
              
              
              
               <?php if (in_array('Reports',$userroles) || ($admin['role_id']==0))
                  { ?> 
               <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="ti ti-report me-2"></i>Report</a>
                  <div id="submenu-4" class="collapse submenu" style="">
                     <ul class="nav flex-column">
                           <?php if (in_array('Daily Report',$userroles) || ($admin['role_id']==0))
                  { ?> 
                          <li class="nav-item">
                           <a class="nav-link" href="daily_report.php">Daily Report</a>
                        </li>
                       <?php  } ?>
                       
                       
                         <?php if (in_array('Customer Report',$userroles) || ($admin['role_id']==0))
                  { ?> 
                          <li class="nav-item">
                           <a class="nav-link" href="customer_report.php">Customer Report</a>
                        </li>
                       <?php  } ?>
                       
                         <?php if (in_array('User Report',$userroles) || ($admin['role_id']==0))
                  { ?> 
                          <li class="nav-item">
                           <a class="nav-link" href="user_report.php">User Report</a>
                        </li>
                       <?php  } ?>
                       
                       
                         <?php if (in_array('Profit Report',$userroles) || ($admin['role_id']==0))
                  { ?> 
                        <li class="nav-item">
                           <a class="nav-link" href="profit_report.php">Profit Report</a>
                        </li>
                                <?php  } ?>
                                
                             <?php if (in_array('Stock Report',$userroles) || ($admin['role_id']==0))
                  { ?> 
                          <li class="nav-item">
                           <a class="nav-link" href="stock_report.php">Stock Report</a>
                        </li>
                       <?php  } ?>    
                                
                          <?php if (in_array('Sale Report',$userroles) || ($admin['role_id']==0))
                  { ?> 
                        <li class="nav-item">
                           <a class="nav-link" href="sale_report.php">Sale Report </a>
                        </li>
                                <?php  } ?>
                  <!--        </?php if (in_array('Profit Report',$userroles) || ($admin['role_id']==0))-->
                  <!--/{ ?> -->
                  <!--      <li class="nav-item">-->
                  <!--         <a class="nav-link" href="report3.php">Profit Report - (day/week/month/year)</a>-->
                  <!--      </li>-->
                  <!--         </?php  } ?>-->
                       
                         <?php if (in_array('Pending Report',$userroles) || ($admin['role_id']==0))
                  { ?>  
                        <li class="nav-item">
                           <a class="nav-link" href="pending_amount.php">Pending Report</a>
                        </li>
                  <?php  } ?>
                    
                       
                     </ul>
                  </div>
               </li>
               <?php } ?>
               <!--<li class="nav-item ">-->
               <!--   <a class="nav-link " href="author.php"><i class="ti ti-user me-2"></i>About Author</a>-->
               <!--</li>-->

               <li class="nav-item ">
                  <a class="nav-link " href="../logout.php"><i class="ti ti-logout me-2"></i>Logout</a>
               </li>
            </ul>
         </div>
      </nav>
   </div>
</div>

