<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>

<?php


$stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE id='" . $_SESSION['id'] . "'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<?php
$sql = "SELECT * FROM tbl_invoice where  id='" . $_POST['id'] . "'";


$statement = $conn->prepare($sql);
$statement->execute();
$invoice = $statement->fetch(PDO::FETCH_ASSOC);

// print_r($invoice);
// exit;

$sql = "SELECT * FROM tbl_manage_website";
$statement = $conn->prepare($sql);
$statement->execute();
$web = $statement->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&display=swap');

        body {
            font-family: "Courier Prime", monospace;
            font-size: 13px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 3px;
        }

        .table th {
            text-align: center;
            background-color: #f2f2f2;
        }

        @media print {
            @page {
                margin: 10px
            }

            button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="ticket">
        <!--<img src="../assets/uploadImage/Logo/<?php echo $web['logo']; ?>" class="img-responsive" style="width: 300px;">-->
        <h3 style="text-align:center">Yokki </h3>
        <div style="display:flex;justify-content:space-between">
            <p class="centered">Invoice</p>
            <p><?= $invoice['build_date']; ?></p>

        </div>
        <p class="centered">

        <p><b>From:</b>Yokii<br>
            <b>Address:</b><?= $result['address'] ?><br>
            <b>Phone:</b><?= $result['contact'] ?><br>
            <b>Email:</b><?= $result['email'] ?><br>



        </p>
        <p><b>To:</b><?= $invoice['customer_id']; ?><br>
            <b>Email:</b><?= $invoice['c_email']; ?><br>
            <b>Phone:</b><?= $invoice['customer_no']; ?><br>
            <b>Address:</b><?= $invoice['c_address']; ?><br>

        </p>

        <br>
        <label>Products</label>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Qty</th>
                    <th>Rate</th>

                    <th style="text-align:right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql2 = "SELECT * FROM quot_inv_items where inv_id='" . $_POST['id'] . "'";


                $statement2 = $conn->prepare($sql2);
                $statement2->execute();
                while ($row2 = $statement2->fetch(PDO::FETCH_ASSOC)) {


                    $sql1 = "SELECT * FROM tbl_product where id='" . $row2['product_id'] . "'";
                    $statement1 = $conn->prepare($sql1);
                    $statement1->execute();
                    $row1 = $statement1->fetch(PDO::FETCH_ASSOC);

                    $stmt3 = $conn->prepare("SELECT * FROM tbl_unit_grp where id='" . $row1['unit'] . "' AND delete_status = '0'");
                    $stmt3->execute();
                    $key3 = $stmt3->fetch();


                    $no += 1;
                ?>
                    <tr>
                        <td class="center"><?= $no ?></td>
                        <td><?= $row1['name'] ?></td>

                        <td><?= $row1['details'] ?></td>
                        <td><?= $key3['name'] ?></td>
                        <td><?= $row2['quantity'] ?></td>
                        <td><?= $row2['rate'] ?></td>

                        <td style="text-align:right"><?= $row2['total'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br>
        <label>Services</label>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Rate</th>

                    <th style="text-align:right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no2 = 1;
                $sql2 = "SELECT * FROM tbl_service_inv_item where inv_id='" . $_POST['id'] . "'";


                $statement2 = $conn->prepare($sql2);
                $statement2->execute();
                while ($row2 = $statement2->fetch(PDO::FETCH_ASSOC)) {

                    $sql11 = "SELECT * FROM tbl_service where id='" . $row2['service_id'] . "'";


                    $statement11 = $conn->prepare($sql11);
                    $statement11->execute();
                    $row11 = $statement11->fetch(PDO::FETCH_ASSOC);


                ?>
                    <tr>
                        <td class="center"><?= $no2; ?></td>
                        <td class="left strong"><?= $row11['name'] ?></td>
                        <td class="left"><?= $row11['details'] ?></td>
                        <td class="center"><?= $row2['quantity'] ?></td>
                        <td class="right"><?= $row2['rate'] ?></td>

                        <td class="right"><?= $row2['total'] ?></td>
                    </tr>
                <?php $no2++;
                } ?>
            </tbody>
        </table>
        <div style="float: left;">
            <table>
                <tr>
                    <td class="left">
                        <strong class="text-dark">Account Details </strong>
                    </td>
                    <td class="right">&nbsp;&nbsp;&nbsp; Yogayog Nursery</td>
                </tr>
                <tr>
                    <td class="left">
                        <strong class="text-dark"> A/c No. </strong>
                    </td>
                    <td class="right">&nbsp;&nbsp;&nbsp; 035704772858195001</td>
                </tr>
                <tr>
                    <td class="left">
                        <strong class="text-dark"> IFSC</strong>
                    </td>
                    <td class="right">&nbsp;&nbsp;&nbsp; CSBK0000357</td>
                </tr>
                <tr>
                    <td class="left">
                        <strong class="text-dark">CSB Bank </strong>
                    </td>
                    <td class="right">&nbsp;&nbsp;&nbsp; Nashik</td>
                </tr>
            </table>
        </div>
        <div style="text-align:right">
            <p><strong class="text-dark">Subtotal :</strong><?= $invoice['subtotal'] ?>
            </p>
            <p><strong class="text-dark">Discount (<?= $invoice['discount'] ?>%) :</strong> <?php
                                                                                            echo $discount = $invoice['subtotal'] * ($invoice['discount'] / 100);
                                                                                            ?>
            </p>
            <p><strong class="text-dark">GST (<?= $invoice['gst_rate'] ?>%)</strong><?php
                                                                                    $gst_rate = ($invoice['subtotal'] - $discount) * ($invoice['gst_rate'] / 100);
                                                                                    echo number_format1($gst_rate, 2);
                                                                                    ?>
            </p>
            <p><strong class="text-dark">Total </strong><?= $invoice['final_total'] ?>
            </p>
        </div>

        <p class="centered">Thank you for your business
        </p>
    </div>
    <button id="printbtn" type="button" value="Print Invoice" onclick="window.print();">Print</button>
</body>

</html>