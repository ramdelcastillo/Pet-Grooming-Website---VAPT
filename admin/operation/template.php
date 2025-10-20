<link rel="stylesheet" href="popup_style.css">

<?php
error_reporting(0);
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

  require_once('../../assets/constants/config.php');

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    if (isset($_POST['update'])) {


      if (!isset($_SESSION['token']) || (!isset($_POST['token']))) {
        exit('token is not set');
      }

      if ($_SESSION['token'] == $_POST['token']) {
        echo "OK";


        $stmt = $conn->prepare("UPDATE `tbl_template` SET `temp1`=?,`temp2`=?,`temp3`=?,`temp4`=?,`temp5`=? WHERE id=? ");


        $stmt->execute([$_POST['temp1'], $_POST['temp2'], $_POST['temp3'], $_POST['temp4'], $_POST['temp5'], $_POST['id']]);

        $_SESSION['success'] = "updated";

        header("location:../enquiry_draft.php");
      }
    }

    if (isset($_POST['update1'])) {


      if (!isset($_SESSION['token']) || (!isset($_POST['token']))) {
        exit('token is not set');
      }

      if ($_SESSION['token'] == $_POST['token']) {
        echo "OK";


        $stmt = $conn->prepare("UPDATE `tbl_template1` SET `temp1`=?,`temp2`=?,`temp3`=?,`temp4`=?,`temp5`=? WHERE id=? ");


        $stmt->execute([$_POST['temp1'], $_POST['temp2'], $_POST['temp3'], $_POST['temp4'], $_POST['temp5'], $_POST['id']]);

        $_SESSION['success'] = "updated";

        header("location:../payment_draft.php");
      }
    }
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
} else {
  header("location:../");
}
