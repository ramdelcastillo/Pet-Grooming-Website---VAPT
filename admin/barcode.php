<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode View</title>
    <!-- Include JsBarcode library -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        /* Ensure no margins and padding */
        body {
            margin: 0;
            padding: 0;
        }

        /* Remove any potential margins and padding */
        svg {
            height: 120px;
            margin: 0;
            padding: 0;
            position: absolute; /* Ensures the barcode is placed at the very top left */
            top: -28px;
            left: 0;
        }

        /* Remove margins and padding during print */
        @media print {
            @page {
                size: landscape;
                margin: 0;
                padding: 0;
            }
        }

        /* Customize text within the barcode */
        .barcode-text {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            font-size: 16px; /* Adjust this size as needed */
        }
       
    </style>
</head>

<body>
    <svg id="barcode"></svg>

    <?php
    require_once('../assets/constants/config.php');

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $sql1 = "SELECT * FROM tbl_product WHERE id='" . $_POST['id'] . "'";
    $statement1 = $conn->prepare($sql1);
    $statement1->execute();
    $row1 = $statement1->fetch(PDO::FETCH_ASSOC);
    $name = $row1['name'];
    $mrp = $row1['unit_price'];
    $id = $row1['id'];
    $size = $row1['openning_stock'];
//   print_r($size);exit;
    ?>

    <!-- JavaScript to generate barcode -->
    <script>
        var barcode_text = "<?php echo htmlspecialchars($id); ?>";
        var price = "<?php echo htmlspecialchars($mrp); ?>";
        var stock = "<?php echo htmlspecialchars($size); ?>";
     
    
        // Generate the barcode
     JsBarcode("#barcode", barcode_text, {
    height: 20,
    textAlign: "left",
    textPosition: "top",
    textMargin: 5,
    width: 4
});

// Add product name above the barcode
var svg = document.getElementById("barcode");
var nameText = document.createElementNS("http://www.w3.org/2000/svg", "text");
nameText.setAttribute("class", "barcode-text");
nameText.setAttribute("x", "35");
nameText.setAttribute("y", "25");
nameText.setAttribute("font-size", "1"); // Smaller font size
nameText.textContent = "<?php echo html_entity_decode($name); ?>";
svg.appendChild(nameText);

// Create details text
var detailsText = document.createElementNS("http://www.w3.org/2000/svg", "text");
detailsText.setAttribute("class", "barcode-text");
detailsText.setAttribute("x", "10");
detailsText.setAttribute("y", "70");
detailsText.setAttribute("font-size", "1"); // Smaller font size

// Price
var priceText = document.createElementNS("http://www.w3.org/2000/svg", "tspan");
priceText.textContent = "₹" + price + "/-";
detailsText.appendChild(priceText);



    var sizeText = document.createElementNS("http://www.w3.org/2000/svg", "tspan");
    sizeText.textContent = stock;
    sizeText.setAttribute("dx", "40"); 
    detailsText.appendChild(sizeText);




// Append details to SVG
svg.appendChild(detailsText);
    </script>

</body>

</html>
