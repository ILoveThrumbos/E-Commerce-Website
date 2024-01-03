<?php
//Start the session
session_start();	
include '../classes/cart.php';

$index = $_POST['index'];
//remove product from the cart if selected - mark as deleted
//If the product is not empty
if ($index != "") {
    $counter = $_SESSION['counter'];
    $cart = new Cart();
    $cart = unserialize($_SESSION['cart']);
    //delete selected product from the cart
    $cart->delete_product($index);
    //update the counter
    //Decrement the counter by one 
	$_SESSION["counter"] = $counter - 1;
	//Serialize and add back to the session
    $_SESSION['cart'] = serialize($cart);
    //Redirect to the view_cart.php
    header("Location:../Pages/cartdisplay_page.php");
    exit();
}
	
?>
