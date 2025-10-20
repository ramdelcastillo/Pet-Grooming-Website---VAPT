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
   
    $sqlq = "SELECT * FROM tbl_customer where cust_id = ? ";
   
   
                                       $stat = $conn->prepare($sqlq);
                                       $stat->execute([$invoice['customer_id']]);
   
   
                                    $cust = $stat->fetch();
   
   
   function number_format1($number, $decimal = 2) {
       // Format the number to fixed decimal places
       $number = number_format((float)$number, $decimal, '.', '');
   
       // Split integer and decimal parts
       $decimalPart = '';
       if (strpos($number, '.') !== false) {
           list($number, $decimalPart) = explode('.', $number);
       }
   
       // Indian number formatting
       $last3 = substr($number, -3);
       $restUnits = substr($number, 0, -3);
   
       if ($restUnits != '') {
           $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
           $formatted = $restUnits . "," . $last3;
       } else {
           $formatted = $last3;
       }
   
       return $decimal > 0 ? $formatted . "." . $decimalPart : $formatted;
   }
   
   
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>invoice</title>
      <style >
         body{
         font-family: system-ui;
         }
         table{
         width: 90%;
         margin: 0 auto;
         border: 1px solid;
         border-collapse: collapse;
         }
         td,th{
         padding: 10px;
         border: 1px solid;
         border-collapse: collapse;
         /*text-align: center;*/
         }
         @media print{
         table{
         width: 100%;
         }
         .trbg{
         color: #000 !important;
         }
         td,th{
         padding: 1px;
         }
         button{
         display: none;
         }
         }
         .td td{
         border-top: none !important;
         border-bottom:none !important;
         }
         .border-bottom td{
         border-bottom:none !important;
         }
         .th th{
             font-size: 13px;
             padding: 10px 0px;
                 background: #ead1f8;
                 -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
         }
         .bg{
             background: #ead1f8;
             -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
         }
      </style>
   </head>
   <body>
      <table>
         <tr>
            <div></div>
            <td rowspan="2" colspan="3">
               <h4 style="margin: 0px"><?= $result['fname']; ?>&nbsp;<?= $result['lname']; ?></h4>
               <?= $result['address'] ?><br>
               <strong>GSTIN :</strong> <?= $result['gstin']; ?>6<br>
               <strong>Mobile :</strong> <?= $result['contact'] ?><br>
            </td>
            <td colspan="4">
               <div style="display: flex;justify-content: space-between;">
                  <p><strong>Invoice No</strong><br>#<?= $invoice['inv_no']; ?></p>
                  <p><strong>Invoice Date</strong><br><?= date("d-m-Y", strtotime($invoice['build_date'])); ?></p>
                  <p><strong>Due Date</strong><br><?= date("d-m-Y", strtotime($invoice['due_date'])); ?></p>
               </div>
            </td>
         </tr>
         <!--<tr>-->
         <!--   <td colspan="4">-->
         <!--      <div style="display: flex;text-align: center;">-->
         <!--         <p><strong>Salesman</strong><br>Arjun S</p>-->
         <!--         <p style="padding-left:35px"><strong>Challan No</strong><br>1234567890</p>-->
         <!--      </div>-->
         <!--   </td>-->
         <!--</tr>-->
         <tr>
            <td colspan="3">
               BILLTO<br>
               <strong><?= $cust['cust_name']; ?></strong><br>
               Mobile: <?= $cust['cust_mob']; ?><br>
               Email: <?= $cust['cust_email']; ?><br>
            </td>
            <td colspan="4">
               <strong>SHIP TO <br><?= $cust['cust_name']; ?></strong>
            </td>
         </tr>
         <?php
            $sql2 = "SELECT * FROM tbl_quot_inv_items where inv_id='" . $_POST['id'] . "'";
            
            
            $statement2 = $conn->prepare($sql2);
            $statement2->execute();
            $res2 = $statement2->fetchAll();
            if(count($res2)>0){
            
            ?>
         <tr class="th">
            <th>S.NO</th>
            <th>Product/Services</th>
            <th>HSN</th>
            <th>WARRANTY EXPIRY DATE</th>
            <th>QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
         </tr>
         <?php
            $fstot=0;
            $ftax=0;
            $fqty=0;
                                                     $cg1=0;
                                                    $sg1=0;
                                                    $ig1=0;
                                                   
                                                    foreach($res2 as $row2){
            
                                                        $sql1 = "SELECT * FROM tbl_product where id='" . $row2['product_id'] . "'";
            
            
                                                        $statement1 = $conn->prepare($sql1);
                                                        $statement1->execute();
                                                        $row1 = $statement1->fetch(PDO::FETCH_ASSOC);
            
            
                                                        $stmt3 = $conn->prepare("SELECT * FROM tbl_unit_grp where id='" . $row1['unit'] . "' AND delete_status = '0'");
                                                        $stmt3->execute();
                                                        $key3 = $stmt3->fetch();
            
                                                        $no += 1;
                                                        
                                                        $stot=$row2['quantity']*$row1['unit_price'];
                                                        $fstot+=$stot;
                                                        $fqty+=$row2['quantity'];
                                                    ?>    
         <tr class="border-bottom">
            <td><?= $no ?></td>
            <td>
               <strong><?= $row1['name'] ?></strong><br>
               <!--IME/Serial No: LG73624780LED1623453-->
            </td>
            <td><?= $row1['hsn'] ?></td>
            <td><?php if($row1['exp']=='0'){
               echo date("d-m-Y", strtotime($row1['exp_date']));
               } else { echo 'No Expiry'; }?></td>
            <td><?= $row2['quantity'] ?>PCS</td>
            <td> <?php echo $web['currency_symbol'] . " " . number_format1($row1['unit_price'], 2); ?></td>
            <td> <?php echo $web['currency_symbol'] . " " . number_format1(($row1['unit_price']*$row2['quantity']), 2); ?></td>
         </tr>
         <tr class="td">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr class="td">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <?php $product=$row1['gst'];       
            $productArray = explode(',', $product);
            foreach($productArray as $pro_med){
              $stax = $conn->prepare("SELECT * FROM tbl_tax where id='" . $pro_med . "' AND delete_status = '0'");
                                                    $stax->execute();
                                                    $tax = $stax->fetch();  
                                                    
                                                  $ftax+=$cgst_amt;
                                                  ?>
         <tr class="td">
            <td></td>
            <td><strong><?php echo  $cgstax=$tax['name']; ?>@<?php echo  $cgst=$tax['percentage']; ?>%</strong></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td><?php echo $web['currency_symbol']; echo number_format1($cgst_amt=($row2['quantity']*$row1['unit_price']*$cgst)/100,2); ?></td>
         </tr>
         <?php 
            }
            
            
            ?>
         <?php } ?>
         <tr class="td">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr class="td">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr class="td">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr class="td">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr class="td">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr class="td">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr class="td">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
         <tr>
            <td class="bg"></td>
            <td class="bg"><strong>Total</strong></td>
            <td class="bg">-</td>
            <td class="bg">-</td>
            <td class="bg"><?php echo number_format1($fqty,2); ?></td>
            <td class="bg">-</td>
            <td class="bg"><?php echo $web['currency_symbol']; echo number_format1(($fstot+$ftax),2);?></td>
         </tr>
      </table>
      <?php  
         foreach($res2 as $row2){
         
                                                $sql1 = "SELECT * FROM tbl_product where id='" . $row2['product_id'] . "'";
         
         
                                                $statement1 = $conn->prepare($sql1);
                                                $statement1->execute();
                                                $row1 = $statement1->fetch(PDO::FETCH_ASSOC);
         
         
                                                $stmt3 = $conn->prepare("SELECT * FROM tbl_unit_grp where id='" . $row1['unit'] . "' AND delete_status = '0'");
                                                $stmt3->execute();
                                                $key3 = $stmt3->fetch();
         
                                                $no += 1;
                                                
                                                $stot=$row2['quantity']*$row1['unit_price'];
                                                $fstot+=$stot;
                                                $fqty+=$row2['quantity'];
                                            ?>    
      <table style="margin-top:10px;">
         <thead>
            <tr>
               <th rowspan="2" class="bg">HSN/SAC</th>
               <th class="bg" rowspan="2">Taxable Value</th>
               <?php  
                  $ftaxtot=0;
                   $product=$row1['gst']; 
                  $productArray = explode(',', $product);
                  foreach($productArray as $pro_med){
                  $stax = $conn->prepare("SELECT * FROM tbl_tax where id='" . $pro_med . "' AND delete_status = '0'");
                                                $stax->execute();
                                                $tax = $stax->fetch();   ?>
               <th colspan="2" class="bg">   <?php    echo  $tax['name']; ?></th>
               <?php   
                  }
                  ?>
               <th rowspan="2" class="bg">Total Tax Amount</th>
            </tr>
            <tr>
              
               <th>Rate</th>
               <th>Amount</th>
               <th>Rate</th>
               <th>Amount</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td><?= $row1['hsn'] ?></td>
               <td style="text-align:end"><?php echo $web['currency_symbol']; echo number_format1(($row2['quantity']*$row1['unit_price']),2); ?></td>
               <?php      $product=$row1['gst']; 
                  $productArray = explode(',', $product);
                  foreach($productArray as $pro_med){
                  $stax = $conn->prepare("SELECT * FROM tbl_tax where id='" . $pro_med . "' AND delete_status = '0'");
                                           $stax->execute();
                                           $tax = $stax->fetch(); 
                                           $cgst=$tax['percentage'];
                                           ?>
               <td style="text-align:end"><?php echo $tax['percentage']; ?> %</td>
               <td style="text-align:end"><?php echo $web['currency_symbol']; echo number_format1($cgst_amt=($row2['quantity']*$row1['unit_price']*$cgst/100),2); ?></td>
               <?php   
                  $ftaxtot+=$cgst_amt;
                  }
                  ?>
               <td style="text-align:end"><?php echo $web['currency_symbol']; echo number_format1($ftaxtot,2); ?></td>
            </tr>
            <tr class="total">
               <td style="text-align:end">Total</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td style="text-align:end"><?php echo $web['currency_symbol']; echo number_format1($ftaxtot+($row2['quantity']*$row1['unit_price']),2); ?></td>
            </tr>
         </tbody>
      </table>
      <?php } ?>
      <?php } ?>
      <table>
         <tr>
            <td>
               <h3>Bank Details</h3>
               <p><strong>Name:</strong> <?= $web['title'];?></p>
               <p><strong>IFSC Code:</strong> <?= $web['ifsc'];?></p>
               <p><strong>Account No:</strong> <?= $web['acc_no'];?></p>
               <p><strong>Bank:</strong> <?= $web['branch'];?>,<?= $web['badd'];?></p>
            </td>
            <td class="qr-code" style="display:flex;justify-content:space-between;height:35vh;align-items:center">
                <div>
               <h3>Payment QR Code</h3>
               <!--<p><strong>UPI ID:</strong> viniprasad1989-1@okhdfcbank</p>-->
               <p>Google Pay | Paytm | UPI</p>
               </div>
               <img src="../assets/uploadImage/Logo/<?php echo $web['qr']; ?>" alt="QR Code" width="80px" height="80px">
            </td>
         </tr>
         <tr>
            <td >
               <!--<h3>Terms and Conditions:</h3>-->
               <!--<p>1. Goods once sold will not be taken back or exchanged</p>-->
               <!--<p>2. All disputes are subject to [ENTER_YOUR_CITY_NAME] jurisdiction only</p>-->
               <?php echo html_entity_decode($web['term']) ;?>
            </td>
            <td class="qr-code" style="text-align:center">
               <p><img src="../assets/uploadImage/Logo/<?php echo $web['sign']; ?>" alt="Signature" width="80px" height="80px"></p>
               <p><strong>Authorized Signatory</strong></p>
            </td>
         </tr>
         <tr>
            
         </tr>
      </table>
      <div style="text-align: center">
         <button onclick="window.print()">Print</button>
      </div>
   </body>
</html>