<?php
// Data access class/script for ecommercedb
$server = "localhost";
$user = "root";
$pass = "";
$database = "ecommercedb";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $mysqli = new mysqli($server, $user, $pass, $database);
    // Set the connection to use UTF-8 encoding
    $mysqli->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log($e->getMessage());
    exit('Error connecting to database');
}
?>
