

<?php
//error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');
/* echo$sql_service1 ="SELECT * FROM tbl_product WHERE id  = 1";
       $statement = $conn->prepare($sql_service1);
 $statement->execute();
                                                             
                                                                
    $service1 = $statement->fetch(PDO::FETCH_ASSOC);
    $data['product']=$service1;
print_r($service1);
*/

?>

<?php
//include('connect.php');


if (isset($_POST['drop_services'])) {
      $sql_service1 = "SELECT * FROM tbl_product WHERE id  = '" . $_POST['drop_services'] . "'";
      $statement = $conn->prepare($sql_service1);
      $statement->execute();


      $service1 = $statement->fetch(PDO::FETCH_ASSOC);

      /*$result1=$conn->query($sql_service1);  
        $service1 = mysqli_fetch_array($result1);
        */
         $sql_service2 = "SELECT name as un FROM tbl_unit_grp WHERE id  = '" . $service1['unit'] . "'";
      $statement1 = $conn->prepare($sql_service2);
      $statement1->execute();


      $service2 = $statement1->fetch(PDO::FETCH_ASSOC);
        
      $data['product'] = $service1;
       $data['unit'] = $service2;
       
       
      echo json_encode($data);
      exit;
}

if (isset($_POST['drop_services22'])) {
      $sql_service1 = "SELECT * FROM tbl_service WHERE id  = '" . $_POST['drop_services22'] . "'";
      $statement = $conn->prepare($sql_service1);
      $statement->execute();


      $service1 = $statement->fetch(PDO::FETCH_ASSOC);

      /*$result1=$conn->query($sql_service1);  
        $service1 = mysqli_fetch_array($result1);
        */
      $data['product'] = $service1;
      echo json_encode($data);
      exit;
}
?>