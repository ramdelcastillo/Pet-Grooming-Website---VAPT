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

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Quotation</title>
  <style>
    .quotation-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }

    .quotation-table th,
    .quotation-table td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }

    @media print {
      button {
        display: none
      }
    }
  </style>
</head>

<body>
  <main class="container">
    <div class="grid">

      <table class="quotation-table">
        <thead>
          <tr>
            <th colspan="6" style="border: 0;">To</th>
          </tr>
          <tr>
            <th colspan="6" style="text-align: right;border: 0">Date: <?= $invoice['build_date']; ?></th>
          </tr>
          <tr>
            <th colspan="6" style="text-align: right;border: 0">Quotation No.: #<?= $invoice['inv_no']; ?></th>
          </tr>
          <tr>
            <th colspan="6" style="text-align: center;border: 0">
              <h2>Quotation</h2>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><b>Sr.No.</b></td>
            <td><b>Products Name</b> </td>
            <td><b>Unit</b> </td>
            <td><b>Qty</b> </td>
            <td><b>Rate</b> </td>
            <td><b>Amount</b> </td>
          </tr>

          <?php
          $no = 1;
          $sql2 = "SELECT * FROM tbl_quot_inv_items where inv_id='" . $_POST['id'] . "'";


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


          ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?= $row1['name'] ?></td>
              <td><?= $key3['name'] ?></td>
              <td><?= $row2['quantity'] ?></td>
              <td><?= $row2['rate'] ?></td>
              <td><?= $row2['total'] ?></td>
            </tr>
          <?php $no++;
          } ?>



          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>

          <?php
          $no = 1;
          $sql2 = "SELECT * FROM tbl_quot_inv_items where inv_id='" . $_POST['id'] . "'";


          $statement2 = $conn->prepare($sql2);
          $statement2->execute();
          $key3 = $statement2->fetch(PDO::FETCH_ASSOC);
          ?>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th>GST (<?= $invoice['gst_rate'] ?>%)</th>
            <th><?php
                $gst_rate = ($invoice['subtotal'] - $discount) * ($invoice['gst_rate'] / 100);
                echo number_format1($gst_rate, 2);
                ?></th>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <th>SUBTOTAL</th>
            <th><?= $invoice['subtotal'] ?></th>
          </tr>
          <tr>
            <td></td>
            <th>Account Details - Yogayog Nursery</th>
            <td></td>
            <td></td>
            <th>TOTAL</th>
            <th><?= $invoice['final_total'] ?></th>
          </tr>
          <tr>
            <td></td>
            <th>A/c No. 035704772858195001</th>
            <td></td>
            <td></td>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <td></td>
            <th>IFSC:- CSBK0000357</th>
            <td></td>
            <td></td>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <td></td>
            <th>CSB Bank Nashik</th>
            <td></td>
            <td></td>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <th colspan="6" style="text-align: center;"><?php echo convertNumberToWords($invoice['final_total']) ?></th>

          </tr>

        </tbody>
      </table>
      <br>
      <br>
      <br>
      <br>
      <table class="quotation-table">
        <tr>
          <th style="text-align: center;border: 0">Receiver</th>
          <th style="text-align: center;border: 0"></th>
          <th style="text-align: center;border: 0">Yogayog Nursery</th>

        </tr>
      </table>


      <button onclick="window.print()">Print this page</button>

    </div>
  </main>


</body>

</html>




<?php

function convertNumberToWords($number)
{
  $words = array(
    '',
    'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
    'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
  );

  $tens = array('', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');

  if ($number == 0) {
    return 'Zero Rupees Only';
  }

  $result = '';

  if ($number >= 1000) {
    $result .= convertNumberToWords(floor($number / 1000)) . ' Thousand ';
    $number %= 1000;
  }

  if ($number >= 100) {
    $result .= $words[floor($number / 100)] . ' Hundred ';
    $number %= 100;
  }

  if ($number > 0) {
    if ($result != '') {
      $result .= 'and ';
    }

    if ($number < 20) {
      $result .= $words[$number];
    } else {
      $result .= $tens[floor($number / 10)];
      if ($number % 10 > 0) {
        $result .= ' ' . $words[$number % 10];
      }
    }
  }

  $result .= ' Rupees Only';

  return $result;
}

?>