<?php
session_start();

require_once '/var/www/html/vendor/autoload.php';  
$dotenv = Dotenv\Dotenv::createImmutable('/var/www/env'); 
$dotenv->load(); 

$servername = $_ENV['DB_HOST'];
$username   = $_ENV['DB_USER'];
$password  = $_ENV['DB_PASS'];
$dbname     = $_ENV['DB_NAME'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // print_r($_POST);exit;
    $response = array();

    try {
        // Establish database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $inv_no = $_POST['id'];

        $stmt = $conn->prepare("SELECT * FROM tbl_invoice WHERE inv_no=:inv_no");
        $stmt->bindParam(':inv_no', $inv_no);

        $execute = $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $inv_due_total = $row['due_total']; 
        $ptype = $_POST['ptype'];
        $inv_paid_amt = $row['paid_amt']; 
        $insta_amt = $_POST['insta_amt'];

        if ($inv_due_total === 0) {
            $_SESSION['error'] = "Already fully paid";
            header('location:../view_order.php');
            exit;
        }

        if (!filter_var($insta_amt, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => $inv_due_total]])) {
            $_SESSION['error'] = "Invalid installment amount";
            $response['status'] = 'error';
            $response['message'] = 'Invalid installment amount';
            header('location:../view_order.php');
            exit;
        }

        if (!filter_var($ptype, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 11]])) {
            $_SESSION['error'] = "Invalid payment method";
            header('location:../view_order.php');
            exit;
        }

        $added_date = date('Y-m-d');

        $sql = "INSERT INTO tbl_installement (inv_no, added_date, insta_amt, due_total, ptype)
        VALUES (:inv_no, :added_date, :insta_amt, :due_total, :ptype)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':inv_no', $inv_no);
        $stmt->bindParam(':added_date', $added_date);
        $stmt->bindParam(':insta_amt', $insta_amt);
        $stmt->bindParam(':due_total', $inv_due_total);
        $stmt->bindParam(':ptype', $ptype);

        $stmt->execute();

        $paid = $inv_paid_amt + $insta_amt;

        $inv_due_total -= $insta_amt;

        $stmt = $conn->prepare("UPDATE tbl_invoice SET due_total = :due_total, paid_amt = :paid_amt WHERE inv_no = :inv_no");
        $stmt->bindParam(':due_total', $inv_due_total);

        $stmt->bindParam(':paid_amt', $paid);

        $stmt->bindParam(':inv_no', $inv_no);


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
