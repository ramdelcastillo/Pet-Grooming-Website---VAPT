<?php
// Include your database configuration file
require_once('../assets/constants/config.php');

// Check if prodId is set in the POST request
if (isset($_POST['prodId'])) {
    $prodId = $_POST['prodId'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the unit price, name, and openning_stock from the database based on prodId
        $stmt = $conn->prepare("SELECT name, unit_price, openning_stock FROM tbl_product WHERE id = :prodId");
        $stmt->bindParam(':prodId', $prodId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Return the unit price, name, and openning_stock as JSON
            echo json_encode([
                'name' => $result['name'],
                'unit_price' => $result['unit_price'],
                'openning_stock' => $result['openning_stock']
            ]);
        } else {
            // Return an error message if the product is not found
            echo json_encode(['error' => 'Error: Product not found.']);
        }
    } catch (PDOException $e) {
        // Return an error message if there's an issue with the database connection
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
} else {
    // Return an error message if prodId is not set in the POST request
    echo json_encode(['error' => 'Error: prodId is not set.']);
}
?>
