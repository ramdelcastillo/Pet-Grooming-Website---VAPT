<?php
session_start();

require_once('../../assets/constants/config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // print_r($_POST);exit;
    $response = array();

    try {
        // Establish database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




        // Prepare SQL statement for inserting data
        $added_date = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO `tbl_installement`(`inv_no`, `added_date`, `insta_amt`,`due_total`,`ptype`) VALUES ('" . $_POST['inv_no'] . "','" . $added_date . "','" . $_POST['insta_amt'] . "','" . $_POST['due_total'] . "','" . $_POST['ptype'] . "')");
        $stmt->execute();
        $paid = $_POST['paid_amt'] + $_POST['insta_amt'];

        //echo $paid;exit;
        $stmt = $conn->prepare("UPDATE `tbl_invoice` SET due_total=:due_total, paid_amt=:paid_amt WHERE id=:id");
        $stmt->bindParam(':due_total', $_POST['due_total']);

        $stmt->bindParam(':paid_amt', $paid);

        $stmt->bindParam(':id', $_POST['id']);


        $execute = $stmt->execute();
        $_SESSION['success'] = "record Updated";
        // If the execution reaches here, the insertion was successful
        $response['status'] = 'success';
        $response['message'] = 'Customer saved successfully';
    } catch (PDOException $e) {
        // An error occurred during database operation
        $response['status'] = 'error';
        $response['message'] = 'Database error: ' . $e->getMessage();
    }

    // Return JSON response to the client-side JavaScript
    echo json_encode($response);
}
