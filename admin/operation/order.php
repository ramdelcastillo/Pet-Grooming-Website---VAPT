<link rel="stylesheet" href="popup_style.css">

<?php
error_reporting(0);
session_start();

if (isset($_SESSION['logged']) && $_SESSION['logged'] == "1" && $_SESSION['role'] == "admin") {

    require_once('../../assets/constants/config.php');

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt4 = $conn->prepare("SELECT * FROM tbl_manage_website");
        $stmt4->execute();
        $key4 = $stmt4->fetch();

        if (isset($_POST['btn_save'])) {
            try {
                // Start transaction
                $conn->beginTransaction();

                // Insert into tbl_invoice
                $stmt = $conn->prepare("INSERT INTO `tbl_invoice`
                ( `build_date`, `customer_id`, `inv_no`,`user`, `subtotal`, `final_total`, `advance_total`, `due_total`, `paid_amt`, `ptype`, `created_date`, `due_date`) 
                VALUES ( :build_date, :customer_id, :inv_no,:user, :subtotal, :final_total, :advance_total, :due_total, :paid_amt, :ptype, :created_date, :due_date)");

                $stmt->execute([
                   
                    ':build_date' => htmlspecialchars($_POST['build_date']),
                    ':customer_id' => htmlspecialchars($_POST['customer_name']),
                 
                    ':inv_no' => htmlspecialchars($_POST['inv_no']),
                     ':user' => htmlspecialchars($_POST['user']),
                    ':subtotal' => htmlspecialchars($_POST['subtotal']),
                    ':final_total' => htmlspecialchars($_POST['final_total']),
                    ':advance_total' => htmlspecialchars($_POST['advance_total']),
                    ':due_total' => htmlspecialchars($_POST['due_total']),
                    ':paid_amt' => htmlspecialchars($_POST['advance_total']), // Ensure this logic is correct
                    ':ptype' => htmlspecialchars($_POST['ptype']),
                    ':created_date' => date('Y-m-d'),
                    ':due_date' => htmlspecialchars($_POST['due_date'])
                ]);

                $last_inserted_id = $conn->lastInsertId();

                // Insert into installement
                $stmt0 = $conn->prepare("INSERT INTO `tbl_installement`
                (`inv_no`, `added_date`, `insta_amt`, `due_total`, `ptype`) 
                VALUES (:inv_no, :added_date, :insta_amt, :due_total, :ptype)");

                $stmt0->execute([
                    ':inv_no' => $_POST['inv_no'],
                    ':added_date' => date('Y-m-d'),
                    ':insta_amt' => $_POST['advance_total'],
                    ':due_total' => $_POST['due_total'],
                    ':ptype' => $_POST['ptype']
                ]);

                // Loop through products
                $product_ids = $_POST['product_id'] ?? [];
                $quantities = $_POST['quantity'] ?? [];
                $rates = $_POST['rate'] ?? [];
                $totals = $_POST['total'] ?? [];

                if (!empty($product_ids) && count($product_ids) == count($quantities)) {

                    for ($i = 0; $i < count($product_ids); $i++) {
                        $product_id = htmlspecialchars($product_ids[$i]);
                        $quantity = htmlspecialchars($quantities[$i]);
                        $rate = htmlspecialchars($rates[$i]);
                        $total = htmlspecialchars($totals[$i]);

                        // Fetch product data
                        $sql = "SELECT * FROM tbl_product WHERE id = :product_id";
                        $statement = $conn->prepare($sql);
                        $statement->execute([':product_id' => $product_id]);
                        $row = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($row) {
                            if ($key4['deduct'] == '1') {
                                $quantity_new = max(0, $row['openning_stock'] - $quantity); // Prevent negative stock

                                // Update stock
                                $stmt13 = $conn->prepare("UPDATE tbl_product SET openning_stock = :openning_stock WHERE id = :id");
                                $stmt13->execute([
                                    ':openning_stock' => $quantity_new,
                                    ':id' => $product_id
                                ]);
                            }

                            // Insert into quot_inv_items
                            $stmt1 = $conn->prepare("INSERT INTO `tbl_quot_inv_items`
                            (`inv_id`, `product_id`, `quantity`, `rate`, `total`) 
                            VALUES (:inv_id, :product_id, :quantity, :rate, :total)");

                            $stmt1->execute([
                                ':inv_id' => $last_inserted_id,
                                ':product_id' => $product_id,
                                ':quantity' => $quantity,
                                ':rate' => $rate,
                                ':total' => $total
                            ]);
                        }
                    }
                }

                // Remove empty product_id entries from quot_inv_items
                $stmt11 = $conn->prepare("DELETE FROM tbl_quot_inv_items WHERE product_id = ''");
                $stmt11->execute();

                // Commit transaction
                $conn->commit();

$_SESSION['success'] = "Invoice Added Succesfully";
      header('location:../view_order.php');
      exit;
            } catch (Exception $e) {
                $conn->rollBack();
                echo "Failed: " . $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    header("location:../");
}
?>
