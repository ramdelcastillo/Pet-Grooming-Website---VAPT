

<?php
error_reporting(0);
require_once('../assets/constants/config.php');
require_once('../assets/constants/check-login.php');
require_once('../assets/constants/fetch-my-info.php');

?>

<?php
session_start();
     ob_clean();
    //include 'connect.php';
    
    require_once('tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('Invoice ');  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage(); 
    $contents = '<table style="padding: 1%;">';
    $contents .= '<tr><td colspan="8"><img src="uploadImage/Logo/letter_head.jpg"/></td></tr>';


    $que_billing="select * from tbl_invoice where id='".$_GET["id"]."'";
    $statement = $conn->prepare($que_billing);
 $statement->execute();
$quatation=$statement->fetch(PDO::FETCH_ASSOC);
    
    $contents .= '<tr><td colspan="4"><b>Party Name : '.$r['name'].'</b></td>
    <td colspan="4" align="right"><b>Invoice No.: '.$quatation['inv_no'].'</b></td></tr>
    <tr><td colspan="4"><b>Representative : '.$represent['name'].'</b></td>
    <td colspan="4" align="right"><b>Date : '.date('d/m/Y',strtotime($quatation['build_date'])).'</b></td></tr>
    <tr><td colspan="8">Dear Sir,<br>We are pleased to quote our most competitive rates as follows ….
    </td></tr>
    <tr><td colspan="8">
    <table style="padding: 1%;" border="1">
    <tr style="background-color:#4c99d6;" align="center"><th width="5%"><b>Sr</b></th><th width="25%"><b>Product</b></th><th><b>Qty.</b></th><th><b>Rate</b></th><th><b>GST %</b></th><th><b>Taxable Amount</b></th><th><b>Tax Amount</b></th><th><b>Total</b></th></tr>';
    $sql_items = "select * from quot_inv_items where inv_id = '".$quatation['id']."'";
    $statement2 = $conn->prepare($sql_items);
 $statement2->execute();
     
    $i=$subtotal=$tax_amount=$taxable_amount=0;
    while($item =$statement2->fetch(PDO::FETCH_ASSOC)){
      $sql = "select *from tbl_product where id = '".$item['product_id']."'";
      $statement1 = $conn->prepare($sql1);
 $statement1->execute();
  $product = $statement1->fetch(PDO::FETCH_ASSOC);
      $i++;
      $subtotal+=$item['total'];
      $tax_amount+=$item['tax_amount'];
      $taxable_amount+=$item['taxable_amount'];
      $contents .= '<tr><td>'.$i.'</td><td>'.$product['name'].'</td><td>'.$item['quantity'].'</td><td>'.$item['rate'].'</td><td>'.$item['gst'].'</td><td>'.$item['taxable_amount'].'</td><td>'.$item['tax_amount'].'</td><td>'.$item['total'].'</td></tr>';
    }
    $contents .= '<tr style="border: 1px solid black;"><td colspan="5" align="right">Total</td><td>'.$taxable_amount.'</td><td>'.$tax_amount.'</td><td>'.$subtotal.'</td></tr></table></td></tr><tr><td colspan="8" align="right">Signature<br>_________________________</td></tr></table>';

     $pdf->writeHTML($contents); 
    ob_end_clean();     
    $pdf->Output('payslip.pdf', 'I');

?>