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



?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Invoice Receipt</title>
      <style>
         body {
         font-family: 'Courier New', Courier, monospace;
         background: #f8f8f8;
         }
         .receipt {
         width: 405px;
         background: white;
         padding:0px 15px;
         border-radius: 5px;
         box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
         margin: 0 auto;
         border: 2px solid black;
         }
         p{
              margin: 10px 0px;
         }
         .receipt h2 {
         margin: 13px 0;
         font-size: 16px;
         }
         .receipt hr {
         border: none;
         border-top: 1px solid black;
         margin: 12px 0;
         }
         .receipt table {
         width: 100%;
         border-collapse: collapse;
         font-size: 12px;
         text-align: left;
         }
         .receipt th, .receipt td {
         padding:7px 0px;
         border-bottom: 1px solid black;
         }
         .footer {
         margin-top: 10px;
         font-size: 10px;
         }
         .barcode {
         height: 40px;
         background: black;
         margin: 10px auto;
         width: 80%;
         }
         @media print{
            button{
                display: none;
            }
         }
      </style>
   </head>
   <body>
      <div class="receipt">
         <h2><?php echo $web['title'];?></h2>
         <p><?php echo $result['address'];?></p>
         <p>Ph:<?php echo $result['contact'];?></p>
         <hr>
         <strong><?php echo $result['fname'];?><?php echo $result['lname'];?></strong><br>
         <!--<span>M.B.B.S.</span><br>-->
         <!--<span>Reg. No: 270988</span>-->
         <hr>
         <p>Date: <?php echo date("d-m-Y", strtotime($invoice['build_date'])); ?></p>
         <p><strong>ID: <?php echo $invoice['inv_no'];?> - <?php echo  $cust['cust_name']; ?></strong><br>Address: <?php echo  $cust['cust_address']; ?></p>
         <hr>
         <table>
            <tr>
                 <th>#</th>
               <th>Product</th>
               <th>Qty</th>
               <th> Rate</th>
               <th>Tax %</th>
             
          
          
          
                 <th>Total</th>
            </tr>
            
            
            <?php  $i=1;
            $fstot=0;
$ftax=0;
            
                                        $sql2 = "SELECT * FROM tbl_quot_inv_items where inv_id='" . $_POST['id'] . "'";


                                        $statement2 = $conn->prepare($sql2);
                                        $statement2->execute();
                                       $res2 = $statement2->fetchAll();
                                       foreach($res2 as $item)
                                       { 
                                       
                                       
                                       
                                            $sql1 = "SELECT * FROM tbl_product where id='" . $item['product_id'] . "'";


                                            $statement1 = $conn->prepare($sql1);
                                            $statement1->execute();
                                            $row1 = $statement1->fetch(PDO::FETCH_ASSOC);
                                            
                                             $stot=$item['quantity']*$row1['selling_gst'];
                                            $fstot+=$stot;
                                            
                                            ?>
            <tr>
                <td><?= $i; ?> </td>
               <td><?= $row1['name'] ?> </td>
               <td><?= $item['quantity'] ?></td>
               <td><?php echo $web['currency_symbol'] . number_format($row1['selling_gst'], 2); ?></td>
               <td >
                    <?php if($row1['exp']==0){
                   $product=$row1['gst']; 
    $productArray = explode(',', $product);
    foreach($productArray as $pro_med){
      $stax = $conn->prepare("SELECT * FROM tbl_tax where id='" . $pro_med . "' AND delete_status = '0'");
                                            $stax->execute();
                                            $tax = $stax->fetch();  
                                           
                                          echo  $cgst=$tax['percentage'];
                                           echo '%('; echo $web['currency_symbol']; echo number_format($cgst_amt=($item['quantity']*$row1['unit_price']*$cgst)/100,2); echo ')';
                                           $ftax+=$cgst_amt;
                                          echo '<br>';
    }
                    }else if($row1['exp']==1){
                        echo ' No Tax';
                        
                    }
    
    ?>
               </td>
           
               <td><?php echo $web['currency_symbol'] . "" . number_format($stot, 2); ?>-/</td>

            </tr>
            <?php $i++;  } ?>
             <tr>
                 <td colspan="5" style="text-align:end;border:none !important;">Subtotal</td>
                <td style="border:none !important;">
    <?php echo $web['currency_symbol'] . "" . number_format($fstot, 2); ?>-/
</td>

             </tr>
<!--                <tr>-->
<!--                 <td colspan="5" style="text-align:end;border:none !important;">Tax</td>-->
<!--                <td style="border:none !important;">-->
<!--    </?php echo $web['currency_symbol'] . " " . number_format($ftax, 2); ?>-->
<!--</td>-->

<!--             </tr>-->
     
         </table>
         <hr>
         <!--<img src="" width="50px" height="50px">-->
         <!--<p class="footer">Pay via UPI</p>-->
         
         
         
         <p>
             <?php echo html_entity_decode($web['term']) ;?>
         </p>
         
      </div>
      <div style="text-align: center;margin-top: 10px">
          <button onclick="window.print()">Print</button>
      </div>
   </body>
</html>