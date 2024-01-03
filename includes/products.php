<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/styles.css"> 
</head>
<body>
<h1>Product Page</h1>
<div class="product-grid">
    <?php
    // Connect to the database server and select the database
    require_once("../includes/conn_ecommercedb.php");

    $query = "SELECT * FROM product";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $product_id = $row["product_id"];
        $product_name = $row["product_name"];
        $product_price = $row["product_price"];
        $product_type = $row["product_type"];
        // $product_image = $row["product_image"];

        echo '<div class="product-item">';
        //echo "<img src='$product_image' alt='$product_name'>";
        echo "<h2>$product_name</h2>";
        echo "<p>$product_type</p>";
        echo "<p>Price: $$product_price</p>";
        echo "<p>Quantity: <input name='product_qty' type='text' value='1' size='2'></p>";
        echo "<button class='add-to-cart' data-product-id='$product_id'>Add to Cart</button>";
        echo '</div>';
    }

    $mysqli->close();
    ?>
</div>

<script type="text/javascript">
function getHTTPObject() {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        if (!xmlhttp) {
            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }
    }
    return xmlhttp;
}

var http = getHTTPObject();

function handleHttpResponse() {
    if ((http.readyState == 4) && (http.status == 200)) {
        var results = http.responseText;
        // You can handle the response here, e.g., show a confirmation message
        //alert(results);
    }
}   

var url = "../includes/add_to_cart.php";

function requestUserInfo(id, quantity) {
    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.onreadystatechange = handleHttpResponse;
    http.send("product_id=" + id + "&product_qty=" + quantity);

}

document.addEventListener('click', function (event) {
    if (event.target && event.target.className == 'add-to-cart') {
        var productId = event.target.getAttribute('data-product-id');
        var quantity = event.target.previousElementSibling.querySelector('input[name="product_qty"]').value;
        requestUserInfo(productId, quantity);
    }
});
</script>
</body>
</html>
