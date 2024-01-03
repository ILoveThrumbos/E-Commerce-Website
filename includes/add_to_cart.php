<?php
// Start the session
session_start();
include '../classes/cart.php';
// Get the product_id and the quantity
$product_id = $_POST["product_id"];
$product_qty = $_POST["product_qty"];
// Store the number of products in the shopping cart
$counter = $_SESSION['counter'];
$cart = new Cart();
// Unserialize the cart if the cart is not empty
if ((isset($_SESSION['counter'])) && ($_SESSION['counter'] != 0)) {
    $counter = $_SESSION['counter'];
    $cart = unserialize($_SESSION['cart']);
} else {
    $_SESSION['counter'] = 0;
    $_SESSION['cart'] = "";
}
if ($product_id == "" || $product_qty < 1) {
    // Redirect the user back to the product page
    header("Location: product.php");
    exit();
} else {
    // Connect to the server and select the database
    require_once("../includes/conn_ecommercedb.php");
    // Create a select query to retrieve the selected product
    $query = "SELECT product_name, product_price, product_type FROM product WHERE product_id = ?";
    // Run the MySQL query
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    // If there is a matching record, select product_name, product_price
    if (mysqli_num_rows($result) == 1) {
        // Add the product to the cart
        $row = $result->fetch_assoc();
        $product_name = $row["product_name"];
        $product_price = $row["product_price"];
        $product_type = $row["product_type"];
        $new_product = new Product($product_id, $product_name, $product_qty, $product_price, $product_type);
        $cart->add_product($new_product);
        // Update the counter
        $_SESSION['counter'] = $counter + 1;
        $_SESSION['cart'] = serialize($cart);
        // Redirect to the view_cart.php
        header("Location: view_cart.php");
        exit();
    } else {
        // Redirect back to the product page
        header("Location: product.php");
        exit();
    }
    $mysqli->close();
}
?>
