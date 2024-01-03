<?php

class Product {

    var $product_id;
    var $product_name;
    var $product_qty;
    var $product_price;
    var $product_type;
	
    function get_product_cost() {
        return $this->product_qty * $this->product_price;
    }
	
    function __construct($product_id, $product_name, $product_qty, $product_price, $product_type) {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->product_qty = $product_qty;
        $this->product_price = $product_price;
        $this->product_type = $product_type;
    }

    function get_product_id() {
        return $this->product_id;
    }

    function get_product_name() {
        return $this->product_name;
    }

    function get_product_qty() {
        return $this->product_qty;
    }

    function get_product_price() {
        return $this->product_price;
    }

    function get_product_type() {
        return $this->product_type;
    }
    

}

class Cart {

    var $products;
    var $depth;

    function __construct() {
        $this->products = array();
        $this->depth = 0;
    }

    function add_product($product) {
        $this->products[$this->depth] = $product;
        $this->depth++;
    }

    function delete_product($index) {
        unset($this->products[$index]);
		$this->products = array_values($this->products);
		$this->depth--;
    }

    function get_depth() {
        return $this->depth;
    }

    function get_product($index) {
        return $this->products[$index];
    }


}

?>