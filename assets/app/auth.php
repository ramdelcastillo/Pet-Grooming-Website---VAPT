<link rel="stylesheet" href="popup_style.css">


<?php
require_once '/var/www/vendor/autoload.php';  
$dotenv = Dotenv\Dotenv::createImmutable('/var/www/env'); 
$dotenv->load();

$servername = $_ENV['DB_HOST'];
$username   = $_ENV['DB_USER'];
$password   = $_ENV['DB_PASS'];
$dbname     = $_ENV['DB_NAME'];

session_start();
//configuration file
require_once('../constants/config.php');

$email_address = $_POST['email'];
$password_raw  = $_POST['password']; // raw password from user input

// print_r($email_address); exit;
//$passw = hash('sha256',$p);
//echo $passw;exit;

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Fetch user by email only, no password in SQL
  $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE email=:email AND delete_status='0'");
  $stmt->bindParam(':email', $email_address);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  //getting number of records found
  if ($result) {
    $role   = $result['role'];
    $avator = $result['image'];
    $_SESSION['id'] = $result['id'];

    switch ($role) {
      case 'admin':
        //echo$pass;
        //echo$row['password'];exit;

        # verifying password using bcrypt
        if (password_verify($password_raw, $result['password'])) {

          admin_login();
        } else {
          //echo "<script>alert('Invalid Login');</script>";
?>
          <div class="popup popup--icon -error js_error-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
              <h3 class="popup__content__title">
                Error
                </h3>
                <p>Invalid Email or Password</p>
                <p>
                  <a href="../../index.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
                </p>
            </div>
          </div>
  <?php
        }
        break;

      case 'users':

        if (password_verify($password_raw, $result['password'])) {

          student_login();
        } else {

          $_SESSION['reply'] = "001";
          header("location:../../");
        }
        break;
    }
  } else {

    $_SESSION['reply'] = "001";
    header("location:../../");
  }
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

function admin_login()
{

  $_SESSION['logged'] = "1";
  $_SESSION['role'] = "admin";
  $_SESSION['email'] = $GLOBALS['email_address'];
  $_SESSION['avator'] = $GLOBALS['avator'];
  /* echo "<script>alert('  Login Successfully');</script>";
 echo "<script>document.location='../../admin'
</script>";*/ ?>
  <div class="popup popup--icon -success js_success-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
      <h3 class="popup__content__title">
        Success
        </h3>
        <p>Login Successfully</p>

        <p>

          <?php echo "<script>setTimeout(\"location.href = '../../admin';\",1500);</script>"; ?>
        </p>
    </div>
  </div>
  </div>
<?php }

function student_login()
{

  $_SESSION['logged'] = "1";
  //$_SESSION['role'] = "users";
  $_SESSION['role'] = $GLOBALS['role'];
  $_SESSION['email'] = $GLOBALS['email_address'];
  $_SESSION['avator'] = $GLOBALS['avator'];
}
?>
