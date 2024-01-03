<?php
session_start();
require_once("conn_ecommercedb.php");

// Get the search query from the URL
$searchQuery = $_GET["q"];

// Perform a partial search on the product name
$query = "SELECT * FROM product WHERE product_name LIKE ?";
$search = "%" . $searchQuery . "%";

$stmt = $mysqli->prepare($query);

if (!$stmt) {
    echo "Failed to prepare the statement";
} else {
    $stmt->bind_param("s", $search);

    if (!$stmt->execute()) {
        echo "Failed to execute the statement";
    } else {
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo '<br/>No suggestions found.';
        } else {
            try {
                while ($row = $result->fetch_assoc()) {
                    $product_id = $row["product_id"];
                    $product_name = $row["product_name"];
                    $product_price = $row["product_price"];
                    $product_type = $row["product_type"];

                    echo '<div class="product-item">';
                    echo "<h2>$product_name</h2>";
                    echo "<p>$product_type</p>";
                    echo "<p>Price: $$product_price</p>";
                    echo "<p>Quantity: <input name='product_qty' type='text' value='1' size='2'></p>";
                    echo "<button class='add-to-cart' data-product-id='$product_id'>Add to Cart</button>";
                    echo '</div>';
                }
            } catch (Exception $ex) {
                echo "Error: " . $ex->getMessage();
            }
        }
    }

   // $stmt->close();
}

//$mysqli->close();
?>

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
            console.log("Server response:", results);
        } else {
            console.error("HTTP request failed:", http.status, http.statusText);
        }
    }

    var url = "../includes/add_to_cart.php";

    function requestUserInfo(id, quantity) {
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.onreadystatechange = handleHttpResponse;
        http.send("product_id=" + id + "&product_qty=" + quantity);

    }

    document.addEventListener('click', function(event) {
        if (event.target && event.target.className == 'add-to-cart') {
            event.stopPropagation(); // Stop the event (adding item to cart) from repeating

            var productId = event.target.getAttribute('data-product-id');
            var quantity = event.target.previousElementSibling.querySelector('input[name="product_qty"]').value;
            requestUserInfo(productId, quantity);
        }
    });
</script>

<?php
$stmt->close();
$mysqli->close();
?>