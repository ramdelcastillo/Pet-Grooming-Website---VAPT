<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>

<!DOCTYPE html>
<html>
    <?php


$stmt = $conn->prepare("SELECT * FROM tbl_expense WHERE id='" . $_POST['id'] . "'");
$stmt->execute();
$expense = $stmt->fetch(PDO::FETCH_ASSOC);
 $sql = "SELECT * FROM tbl_project where delete_status='0' AND id=? ";


                                        $statement = $conn->prepare($sql);
                                        $statement->execute([$expense['project']]);


                                       $row = $statement->fetch();
                                       
                                       
                                       $date = new DateTime($expense['created_date']);
$formatted_date = strtoupper($date->format('M')) . $date->format('y');

?>
<head>
	<title>PAYMENT VOUCHER</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<style>
		table{
			border: 3px solid ;
			border-collapse: collapse;
			width: 80%;
			margin: 0 auto;
		}
		td,th{
			border: 1px solid ;
			border-collapse: collapse;
			padding: 10px;
		}
		.text-center{
			text-align: center;
		}
		.hight{
			height: 150px;
		}
		p{
			margin: 0px;
			margin-top: 100px;
		}
		@media print{
			button{
				display: none;
			}
		}
	</style>
</head>
<body>
<table>
	<tr>
		<th colspan="3">DHEER INFRASTUCTURE</th>
	</tr>
	<tr>
		<th colspan="3">CASH PAYMENT VOUCHER</th>
	</tr>
	<tr>
		<td class="text-center">VOUCHER NO.</td>
		<td class="text-center" colspan="2">VAD/<?php echo $formatted_date; ?>/00<?php echo $expense['id'] ?></td>
	</tr>
	<tr>
		<td>Amount : <strong><?php echo $expense['amount'] ?></strong></td>
		<td colspan="2">Date : <strong><?php echo $expense['created_date'] ?></strong></td>
	</tr>
	<tr>
		<th colspan="3">Method Of Payment</th>
	</tr>
	<tr>
		<td>Cash : <strong><?php if($expense['pay_method']=='1'){echo 'Cash Payment';} else{echo '-';} ?></strong></td>
		<td colspan="2">Cheque# : <strong> <?php if($expense['pay_method']=='2'){echo 'Cheque Payment';} else{echo '-';}?> </strong></td>
	</tr>
	<tr>
		<td colspan="3">To : <strong><?php echo $row['name'] ?> Project</strong></td>
	</tr>
	<tr>
		<td colspan="3">The Sum Of : <strong><?php 
		$number = $expense['amount'];
$locale = 'en_US';
$fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
$in_words = numfmt_format($fmt, $number);

print_r($in_words);
?> only</strong></td>
	</tr>
	<tr>
		<td colspan="3">Being : <strong>Amount Paid For <?php echo $expense['expe_for'] ?>	</strong></td>
	</tr>
	<tr>
		<td class="text-center hight">
			<p>Approved By : <br>Signature</p>
		</td>
		<td class="text-center hight">
			<p>Paid By : <br>Signature</p>
		</td>
		<td class="text-center hight">
			<p>Recived By : <br>Signature</p>
		</td>
	</tr>
</table>
<div class="text-center" style="margin-top: 10px">
	<button onclick="window.print()">PRINT</button>
</div>
</body>
</html>