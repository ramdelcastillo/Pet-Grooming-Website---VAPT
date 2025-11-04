<link rel="stylesheet" href="popup_style.css">

<?php
require_once '/var/www/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('/var/www/env');
$dotenv->load();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

session_start();

require_once('../constants/config.php');

$email_address = $_POST['email'];
$password_raw = $_POST['password']; 

$ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0] : $_SERVER['REMOTE_ADDR'] ?? 'unknown';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $conn->prepare("SELECT COUNT(*) as failed_count 
                        FROM tbl_login_attempts 
                        WHERE attempted_at >= NOW() - INTERVAL 15 MINUTE");
  $stmt->execute();
  $failed = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($failed['failed_count'] >= 5) {
    die('<div class="popup popup--icon -error js_error-popup popup--visible">
                <div class="popup__background"></div>
                <div class="popup__content">
                    <h3 class="popup__content__title">Error</h3>
                    <p>Too many login attempts. Try again later.</p>
                    <p><a href="../../index.php"><button class="button button--error" data-for="js_error-popup">Close</button></a></p>
                </div>
             </div>');
  }

  $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE email=:email AND delete_status='0'");
  $stmt->bindParam(':email', $email_address);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check password if user exists
  $login_success = $result && password_verify($password_raw, $result['password'] ?? '');

  if ($login_success) {
    // Reset old failed attempts
    $stmt = $conn->prepare("DELETE FROM tbl_login_attempts 
                        WHERE attempted_at < NOW() - INTERVAL 15 MINUTE");

    $stmt->execute();

    $role = $result['role'];
    $avator = $result['image'];
    $_SESSION['id'] = $result['id'];

    if ($role === 'admin') {
      admin_login();
    } else {
      student_login();
    }

  } else {
    $stmt = $conn->prepare("INSERT INTO tbl_login_attempts (ip_address) VALUES (:ip)");
    $stmt->bindParam(':ip', $ip);
    $stmt->execute();

    ?>
    <div class="popup popup--icon -error js_error-popup popup--visible">
      <div class="popup__background"></div>
      <div class="popup__content">
        <h3 class="popup__content__title">Error</h3>
        <p>Invalid Email or Password</p>
        <p><a href="../../index.php"><button class="button button--error" data-for="js_error-popup">Close</button></a></p>
      </div>
    </div>
    <?php
    exit;
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
  ?>
  <div class="popup popup--icon -success js_success-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
      <h3 class="popup__content__title">Success</h3>
      <p>Login Successfully</p>
      <p><?php echo "<script>setTimeout(\"location.href = '../../admin';\",1500);</script>"; ?></p>
    </div>
  </div>
  <?php
}

function student_login()
{
  $_SESSION['logged'] = "1";
  $_SESSION['role'] = $GLOBALS['role'];
  $_SESSION['email'] = $GLOBALS['email_address'];
  $_SESSION['avator'] = $GLOBALS['avator'];
}
?>