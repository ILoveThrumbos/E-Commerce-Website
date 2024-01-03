<?php
// Start the session
session_start();
include '../classes/cart.php';
$cart = new Cart();
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
    $counter = 0;
} else {
    $counter = $_SESSION['counter'];
}
$total_price = 0;
?>

<html>
<body>

<?php
// Check whether the cart is empty or not
if ($counter == 0) {
    echo "<h1>Shopping Cart</h1>";
    echo "<br><br><p><b>Your Shopping Cart is empty !!!</b></p>";
    echo "<p><b><a href=viewproducts_page.php>Go back to products</a></b></p>";
} else {
    $cart = unserialize($_SESSION['cart']);

    // Get the depth of the cart
    $depth = $cart->get_depth();
    echo "<h1>Shopping Cart</h1>";
    echo "<form action='../includes/remove_from_cart.php' method='POST'>";
    echo "<table border=1>";
    echo "<tr><td><b>Product Name</b></td><td><b>Type</b></td><td><b>Price</b></td><td><b>Quantity</b></td></tr>";

    // Use a for loop to iterate through the cart
    for ($i = 0; $i < $depth; $i++) {
        $product = $cart->get_product($i);
        $product_id = $product->get_product_id();
        $product_name = $product->get_product_name();
        $product_qty = $product->get_product_qty();
        $product_price = $product->get_product_price();
        $product_type = $product->get_product_type();

        $total_price = $total_price + $product_price;

        echo "<tr>";
        echo "<td>$product_name</td><td>$product_type</td><td>$$product_price</td><td>$product_qty</td>";
        echo "<input type='hidden' name='index' value='$i'>";
        echo "<td><input type='submit' name='remove' value='Remove'></td>";
        echo "</tr>";

    }

    echo "<tr><td><b>Total Item Price</b></td><td></td><td><b>$" . number_format($total_price, 2) . "</b></td><td></td></tr>";
    echo "</table>";
    echo "<p><b><a href='checkout_page.php'>Checkout</a></b></p>";
    echo "<p><b><a href='viewproducts_page.php'>Go back to products</a></b></p>";
    echo "</form>";
}
?>
</body>
</html>
