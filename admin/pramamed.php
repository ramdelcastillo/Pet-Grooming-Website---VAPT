<!DOCTYPE html>
<html>
   <head>
      <title>invoice</title>
      <style >
         body{
         font-family: system-ui;
         }
         table{
         width: 80%;
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
      </style>
   </head>
   <body>
      <table>
         <tr>
            <td rowspan="2" colspan="3">
               <h4 style="margin: 0px">Shivam Electronics</h4>
               Hebbal, Bangalore - 560093, Bangalore,<br>
               Karnataka, 560093<br>
               <strong>GSTIN :</strong> 29GGGGG1314RIZ6<br>
               <strong>Mobile :</strong> 9902510999<br>
            </td>
            <td colspan="4">
               <div style="display: flex;justify-content: space-between;">
                  <p><strong>Invoice No</strong><br>30</p>
                  <p><strong>Invoice Date</strong><br>15/01/2025</p>
                  <p><strong>Due Date</strong><br>14/02/2025</p>
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="4">
               <div style="display: flex;text-align: center;justify-content: space-around;">
                  <p><strong>Salesman</strong><br>Arjun S</p>
                  <p><strong>Challan No</strong><br>1234567890</p>
               </div>
            </td>
         </tr>
         <tr>
            <td colspan="3">
               BILLTO<br>
               <strong>AJAY SHAH</strong><br>
               Mobile: 9993349993<br>
               Email: ajshah@gmail com<br>
            </td>
            <td colspan="4">
               <strong>SHIP TO <br>AJAY SHAH</strong>
            </td>
         </tr>
         <tr>
            <th>S.NO</th>
            <th>ITEMS</th>
            <th>HSN</th>
            <th>WARRANTY EXPIRY DATE</th>
            <th>QTY</th>
            <th>RATE</th>
            <th>AMOUNT</th>
         </tr>
         <tr class="border-bottom">
            <td>1</td>
            <td><strong>LG 65-inch QLED 4K Smart TV (OLED65C1PTB)</strong><br>
IME/Serial No: LG73624780LED1623453</td>
            <td>2646551566</td>
            <td>10 jan 2025</td>
            <td>1PCS</td>
            <td>545511</td>
            <td>16466</td>
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
            <td><strong>CGST@9%</strong></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>28678</td>
         </tr>
         <tr class="td">
            <td></td>
            <td><strong>SGST@9%</strong></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>57867</td>
         </tr>
         <tr>
            <td></td>
            <td><strong>Total</strong></td>
            <td>-</td>
            <td>-</td>
            <td>1</td>
            <td>-</td>
            <td>57867</td>
         </tr>
      </table>
      <table>
        <thead>
            <tr>
                <th rowspan="2">HSN/SAC</th>
                <th>Taxable Value</th>
                <th colspan="2">CGST</th>
                <th colspan="2">SGST</th>
                <th rowspan="2">Total Tax Amount</th>
            </tr>
            <tr>
                
               
                <th>Rate</th>
                <th>Amount</th>
                <th>Rate</th>
                <th>Amount</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>85287219</td>
                <td>83,813.56</td>
                <td>9%</td>
                <td>7,543.22</td>
                <td>9%</td>
                <td>7,543.22</td>
                <td>₹15,086.44</td>
            </tr>
            <tr class="total">
                <td>Total</td>
                <td>83,813.56</td>
                <td></td>
                <td>7,543.22</td>
                <td></td>
                <td>7,543.22</td>
                <td>₹15,086.44</td>
            </tr>
        </tbody>
    </table>
      <table>
        <tr>
            <td>
                <h3>Bank Details</h3>
                <p><strong>Name:</strong> Vinith</p>
                <p><strong>IFSC Code:</strong> HDFC0001182</p>
                <p><strong>Account No:</strong> 12345678915769</p>
                <p><strong>Bank:</strong> HDFC Bank, MUMBAI - KANDIVALI EAST</p>
            </td>
            <td class="qr-code">
                <h3>Payment QR Code</h3>
                <p><strong>UPI ID:</strong> viniprasad1989-1@okhdfcbank</p>
                <p>Google Pay | Paytm | UPI</p>
                <img src="qr-code-placeholder.png" alt="QR Code" width="50px" height="50px">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <h3>Terms and Conditions:</h3>
                <p>1. Goods once sold will not be taken back or exchanged</p>
                <p>2. All disputes are subject to [ENTER_YOUR_CITY_NAME] jurisdiction only</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="qr-code">
                <p><img src="signature-placeholder.png" alt="Signature" width="50px" height="50px"></p>
                <p><strong>Authorized Signatory</strong></p>
            </td>
        </tr>
    </table>
    <div style="text-align: center">
    <button onclick="window.print()">Print</button>
 </div>
   </body>
</html>