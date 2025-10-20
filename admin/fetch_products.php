<?php
require_once('../assets/constants/config.php'); // Your database connection file
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

if (isset($_POST['product_group_id'])) {
    $product_group_id = $_POST['product_group_id'];

    $sql = "SELECT id, name FROM tbl_product WHERE group_id = :product_group_id AND delete_status = 0 ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_group_id', $product_group_id, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($products);
}
?>
