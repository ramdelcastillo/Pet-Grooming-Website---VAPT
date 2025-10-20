 <?php
    require_once('../assets/constants/check-login.php');

    require_once('../assets/constants/config.php');
    require_once('../assets/constants/fetch-my-info.php');

    $sql = "SELECT * FROM tbl_manage_website where status='0'";


    $statement = $conn->prepare($sql);
    $statement->execute();


    $row = $statement->fetch(PDO::FETCH_ASSOC);
    extract($row); ?>


 
 
 <style>
 html{
     overflow-x: hidden !important;
 }
     .footer {
         position: fixed;
         left: 0;
         bottom: 0;
         width: 100%;
         text-align: center;
     }
     
.toast-1{
    opacity: 1 !important;
    position: absolute;
    top: 0px !important;
    right: 0px;
    width: 30%;
    z-index: 100;
    background: #fff;
}
 </style>
 
 
 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!--Toast Container -->
  <?php if (!empty($_SESSION['success'])) { ?>
 <div class="toast toast-1 animate__animated animate__backInRight" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header bg-white">
     <img src="./assets/images/right.png" class="rounded mr-2" alt="...">
    <strong class="mr-auto">
       
        <?php echo $_SESSION['success']; ?>
    </strong>
    
  </div>
</div>
  <?php $_SESSION['success'] = ''; ?>
<?php } ?>

  <?php if (!empty($_SESSION['error'])) { ?>
 <div class="toast toast-1 animate__animated animate__backInRight" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header bg-white">
     <img src="./assets/images/wrong.png" class="rounded mr-2" alt="...">
    <strong class="mr-auto">
       
        <?php echo $_SESSION['error']; ?>
    </strong>
    
  </div>
</div>
  <?php $_SESSION['error'] = ''; ?>
<?php } ?>
 <div class="footer">
     <div class="container-fluid">
         <div class="row">
             <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                 All rights reserved. Dashboard by <?php echo $footer; ?>
                 <a href="#"></a>.
             </div>
             <!--<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">-->
             <!--    <div class="text-md-right footer-links d-none d-sm-block">-->
             <!--        <a href="javascript: void(0);">About</a>-->
             <!--        <a href="javascript: void(0);">Support</a>-->
             <!--        <a href="javascript: void(0);">Contact Us</a>-->
             <!--    </div>-->
             <!--</div>-->
         </div>
     </div>
 </div>
 <script>
     
// preloader
function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 1000);
    function checkReady() {
        if (document.getElementsByTagName('body')[0] !== undefined) {
            window.clearInterval(intervalID);
            callback.call(this);
        }
    }
}

function show(id, value) {
    document.getElementById(id).style.display = value ? 'block' : 'none';
}

onReady(function () {
    show('page', true);
    show('loading', false);
});

 </script>
 <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script><script src="assets/libs/js/main-js.js"></script>
<script src="assets/libs/js/jquery.js"></script>
 <script>
  window.addEventListener('DOMContentLoaded', () => {
    const toast = document.querySelector('.toast-1');
    if (toast) {
      setTimeout(() => {
        toast.classList.add('animate__fadeOutRight');
        toast.addEventListener('animationend', () => toast.remove());
      }, 3000);
    }
  });
</script>