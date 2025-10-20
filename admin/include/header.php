


<?php
//error_reporting(0);
require_once('../assets/constants/check-login.php');

require_once('../assets/constants/config.php');

require_once('../assets/constants/fetch-my-info.php');
?>

<?php
$stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id='".$_SESSION['id']."'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);



 $sql = "SELECT * FROM tbl_manage_website where status='0'";
 
                
  $statement = $conn->prepare($sql);
                                                 $statement->execute();
                                                             
                                                                
                                              $row = $statement->fetch(PDO::FETCH_ASSOC);
                                              
                                              
                                              
                                              
                                                                    extract($row);


function number_format1($number, $decimal = 2) {
    $decimalPart = '';
    
    // Ensure the number is properly formatted with required decimals
    $number = number_format((float)$number, $decimal, '.', '');
    
    if (strpos($number, '.') !== false) {
        list($number, $decimalPart) = explode('.', $number);
    }

    $last3 = substr($number, -3);
    $restUnits = substr($number, 0, -3);

    if ($restUnits != '') {
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
        $formatted = $restUnits . "," . $last3;
    } else {
        $formatted = $last3;
    }

    return $decimal > 0 ? $formatted . "." . $decimalPart : $formatted;
}


                                                                    ?>

<body>
    <div id="page"></div>
<div id="loading"></div>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">


                <!--<a class="navbar-brand" href="index.php">-->
                
                <!--                <img class="img-fluid" src="../assets/uploadImage/Logo/<?php echo$login_logo; ?>" style="width:200px;height:auto;" alt="Theme-Logo" />-->
                <!--            </a>-->
 
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                     <div class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <!--<input class="form-control" type="text" placeholder="Search..">-->
                                <!--<button class="btn search-btns" type="submit"><i class="fas fa-search"></i></button>-->
                            </div>
                        </div>
     
                    <ul class="navbar-nav ml-auto navbar-right-top">
                       
                        <!-- <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-3.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">John Abraham </span>is now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-4.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-5.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jessica Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="#">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/github.png" alt="" > <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dribbble.png" alt="" > <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dropbox.png" alt="" > <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/bitbucket.png" alt=""> <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/mail_chimp.png" alt="" ><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/slack.png" alt="" > <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li>
                         -->
                         
                                                      <li class="mt-3 text-start" style="margin-right:120px;text-color:black;">
                              <?php
date_default_timezone_set('Asia/Kolkata'); // Set to Indian time
echo date('D M d Y H:i:s') . ' GMT+0530 (India Standard Time)';
?>
                               </li>  
                               
                                  <li  class="list-inline-item google-multi languge-list mt-3">
                                        <div id="google_translate_element">
                                            
                                        </div>
                                    </li>
                         <li class="pt-3">
                             <div class="nav-user-info title3 info-user">
                                    <h6 class="mb-0 text-white nav-user-name"><?=$result['fname'];?><?=$result['lname'];?> </h6>
                                    <span class="status"></span><span class="ml-2"><?php if($result['admin_user']!='1'){ ?><?=$result1['name'];?><?php } ?></span>
                                </div>
                         </li>
                         <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="profile.php" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../assets/uploadImage/Profile/<?=$result['image']?>" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info d-flex align-items-center justify-content-between bg-white text-dark border-bottom">
                                   <img src="../assets/uploadImage/Profile/<?=$result['image']?>" alt="" class="user-avatar-md rounded-circle"> <h6 class="mb-0 text-dark nav-user-name"><?=$result['fname'];?><?=$result['lname'];?> </h6>
                                    <!--<span class="status"></span><span class="ml-2">Available</span>-->
                                </div>
                                <a class="dropdown-item" href="profile.php"><i class="ti ti-user "></i> Profile</a>
                                <a class="dropdown-item" href="change_pass.php"><i class="ti ti-key "></i> Change Password</a>
                                <div class="p-1">
                                 <a class="dropdown-item bg-orange text-white text-center" href="../logout.php"><i class="ti ti-logout "></i> Logout</a>
                                 </div>
                            </div>
                        </li>
   </ul>

                </div>
            </nav>
        </div>



