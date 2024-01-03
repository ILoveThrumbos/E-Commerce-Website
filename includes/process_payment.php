<?php
// Start the session
session_start();
require_once('phpcreditcard.php');
include '../classes/cart.php'; // Include the cart class
require_once('conn_ecommercedb.php');
require_once('gen_id.php');

$cart = new Cart();

// Read the values from the form
$name = $_POST["name"];
$email = $_POST["email"];
$address = $_POST["address"];
$card_type = $_POST["card_type"];
$exp_date = $_POST["exp_date"];
$card_no = $_POST["card_no"];
$code = $_POST["code"];
$total_price = $_POST["total_price"];

// Validate the text fields and the credit card
if (
    empty($name) || empty($email) || empty($address) || empty($card_type) ||
    empty($exp_date) || empty($card_no) || empty($code)
) {
    echo "<p>Required Field(s) missing...!!!! Go back and Try again...!!!!.</p>";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<p>Invalid Email...!!!! Go back and Try again...!!!!.</p>";
} elseif (!checkCreditCard($card_no, $card_type, $ccerror, $ccerrortext)) {
    echo $ccerrortext;
} else {
    // If there are no errors
    $counter = $_SESSION['counter'];

    if ($counter == 0) {
        echo "<br><br><p><b>Your Shopping Cart is empty !!!</b></p>";
    } else {
        // Convert the cart string to a cart object
        $cart = unserialize($_SESSION['cart']);
        $depth = $cart->get_depth();
        // Generate the order ID
        $order_id = gen_id(8);
        $total_price = 0;

        // Use a for loop to iterate through the cart
        for ($i = 0; $i < $depth; $i++) {
            $product = $cart->get_product($i);
            $product_id = $product->get_product_id();
            $product_qty = $product->get_product_qty();
            $product_price = $product->get_product_price();
            $total_price += $product_price * $product_qty;

            // Add the record to customer_order_line table
            $query = "INSERT INTO customer_order_line (order_id, product_id, product_qty) VALUES (?, ?, ?)";
            try {
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("ssi", $order_id, $product_id, $product_qty);
                $stmt->execute();
            } catch (Exception $e) {
                error_log($e->getMessage());
                exit('Error inserting into customer_order_line table');
            }
        }
        // Add the record to order table
        $order_status = "posted";
        $tax = 0.10;
        $sales_tax = $total_price * $tax;
        $shipping_cost = 5;

        // Create the insert query for the order table
        $query = "INSERT INTO customer_order (order_id, customer_email, order_status, order_total, sales_tax, shipping_charges)  
        VALUES (?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $mysqli->prepare($query);

            // Bind parameters
            $stmt->bind_param("issddd", $order_id, $email, $order_status, $total_price, $sales_tax, $shipping_cost);

            // Execute the query
            $stmt->execute();
            echo "<p> <b>Order added......!!!! Order ID: $order_id  </p>";
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo '<p>Error Message: ' . $e->getMessage() . '</p>';
            echo '<p>Error Code: ' . $stmt->errno . '</p>';
            echo '<p>Error Description: ' . $stmt->error . '</p>';
            exit('Error inserting into customer_order table');
        }


        // Display order details
        echo "<h1>Order Details</h1>";
        echo "<p><b>Order ID:</b> $order_id</p>";
        echo "<p><b>Credit Card Number:</b> $card_no</p>";
        echo "<p><b>Card Holder's Name:</b> $name</p>";
        echo "<p><b>Billing Address:</b> $address</p>";
        echo "<p><b>Product Price:</b> $" . number_format($total_price, 2) . "</p>";
        echo "<p><b>Sales Tax:</b> (10%)$$sales_tax</p>"; 
        echo "<p><b>Shipping Charges:</b>$$shipping_cost</p>"; 
        echo "<p><b>Sum Total Price(Shipping Included):</b> $". number_format($total_price + $sales_tax + $shipping_cost, 2) ."</p>"; 

        // Email the invoice (You should configure email functionality)
        //$message = "Thanks for your order, your order ID is $order_id";
        // mail($email, "Order Confirmation", $message);

        // Empty the cart
        unset($_SESSION['cart']);
        unset($_SESSION['counter']);

        echo "<p><b><a href='../Pages/viewproducts_page.php'>Go back to Products</a></b></p>";
    }
}

$mysqli->close();
?>