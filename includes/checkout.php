<?php
// Start the session
session_start();


include '../classes/cart.php';
$cart = new Cart();
$counter = $_SESSION['counter'];
$total_price = 0;

// Check whether the cart is empty or not
if ($counter == 0) {
    echo "<br><br><p><b>Your Shopping Cart is empty !!!</b></p>";
} else {
    $cart = unserialize($_SESSION['cart']);
    $depth = $cart->get_depth();
    echo "<h1>Shopping Cart Checkout</h1>";
    // echo "<form action='process_payment.php' method='post'>";
    echo "<table border=1>";
    echo "<tr><td><b>Product Name</b></td><td><b>Type</b></td><td><b>Price</b></td><td><b>Quantity</b></td></tr>";
    
    // Use a for loop to iterate through the cart
    for ($i = 0; $i < $depth; $i++) {
        $products = $cart->get_product($i);
        $product_id = $products->get_product_id();
        $product_name = $products->get_product_name();
        $product_qty = $products->get_product_qty();
        $product_price = $products->get_product_price();
        $product_type = $products->get_product_type(); 
        
        // Calculate the total price
        $total_price = $total_price + $product_price;
        
        echo "<tr>";
        echo "<td>$product_name</td><td>$product_type</td><td>$$product_price</td><td>$product_qty</td>";
        echo "<input type='hidden' name='index' value='$i'>";
        // echo "<form action='../includes/remove_from_cart.php' method='POST'>";
        // echo "<td><input type='submit' name='remove' value='Remove'></td>";
        echo "</tr>";
    }
   
    // Display the total price
    $sales_tax_rate = 0.1; 
    $shipping_cost = 5;
    $sales_tax_amount = $total_price * $sales_tax_rate;
    $_SESSION['order_details'] = array(
        'total_price' => $total_price,
        'sales_tax' => $sales_tax_amount,
        'shipping_cost' => $shipping_cost,
        'cart' => $_SESSION['cart']
    );
    

    echo "<tr><td><b>Total Item Price</b></td><td></td><td><b>$" . number_format($total_price, 2) . "</b></td><td></td></tr>";
    echo "<tr><td><b>Sales Tax</b></td><td></td><td><b>$" . number_format($sales_tax_amount, 2) . "</b></td><td></td></tr>";
    echo "<tr><td><b>Shipping Cost</b></td><td></td><td><b>$" . number_format($shipping_cost, 2) . "</b></td><td></td></tr>";


    // Include hidden input fields for shipping cost, sales tax, and total item price
    echo "<input type='hidden' name='shipping_cost' value='$shipping_cost'>";
    echo "<input type='hidden' name='sales_tax' value='$sales_tax_amount'>";
    echo "<input type='hidden' name='total_price' value='$total_price'>";


    echo "<tr><td><b>Total Price(shipping Included)</b></td><td></td><td><b>$" . number_format($shipping_cost + $sales_tax_amount + $total_price, 2) . "</b></td><td></td></tr>";
    echo "</table>";
    echo"<p><b> <a href=payment_page.php>Proceed with Payments</a> </b></p>";
    // echo "</form>";
    echo "<p><b><a href=cartdisplay_page.php>Remove product from the Cart</a></b></p>";
    echo "<p><b><a href=viewproducts_page.php>Go back to products</a></b></p>";
}
?>
