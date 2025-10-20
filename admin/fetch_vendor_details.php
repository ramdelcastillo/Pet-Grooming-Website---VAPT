<?php
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php'); // Include your database connection file

if (isset($_POST['id'])) {
    $vendorID = $_POST['id'];

    $sql = "SELECT email, address, contact FROM tbl_labour WHERE id = :id AND delete_status = '0'";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $vendorID, PDO::PARAM_INT);
    $statement->execute();
    $vendor = $statement->fetch(PDO::FETCH_ASSOC);

    if ($vendor) {
        echo json_encode($vendor);
    } else {
        echo json_encode(null);
    }
}
?>
