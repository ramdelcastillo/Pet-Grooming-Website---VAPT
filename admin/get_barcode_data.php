<?php

require_once('../assets/constants/config.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the barcode from the AJAX request
$barcode = $_POST['barcode'];

// Query the barcode table to get the product_id
$sqlBarcode = "SELECT product_id FROM tbl_barcode WHERE barcode = '$barcode'";
$resultBarcode = $conn->query($sqlBarcode);

if ($resultBarcode->num_rows > 0) {
    $rowBarcode = $resultBarcode->fetch_assoc();
    $product_id = $rowBarcode['product_id'];

    // Query the product table based on the obtained product_id
    $sqlProduct = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
    $resultProduct = $conn->query($sqlProduct);

    if ($resultProduct->num_rows > 0) {
        // If a matching product is found, return the product information as JSON
        $rowProduct = $resultProduct->fetch_assoc();
        $product = array(
            'product_id' => $rowProduct['product_id'],
            'product_name' => $rowProduct['product_name'],
            'price' => $rowProduct['price']
            // Add other product information as needed
        );
        echo json_encode($product);
    } else {
        // If no matching product is found, you can return an error or an empty response
        echo json_encode(array('error' => 'Product not found'));
    }
} else {
    // If no matching barcode is found, you can return an error or an empty response
    echo json_encode(array('error' => 'Barcode not found'));
}

// Close the database connection
$conn->close();

?>
