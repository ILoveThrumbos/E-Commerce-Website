<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Customer Login</title>
    <h1>Verify Customer Login</h1>
    <link rel="stylesheet" href="../css/contain.css">
</head>

<body>
    <?php
    /*
    Page Name: VerifyCustomerLogin.php
    Date: 18/05/2023
    Author: Your Name
    Purpose: MYSQL database for customer login verification,
    hash() for user passwords and password verification.
    */

     // Start a session or resume the current session
     session_start();

     // Include the database connection file
     require_once('conn_ecommercedb.php');
 
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $customer_email = ($_POST["customer_email"]);
         $customer_password = ($_POST["customer_password"]);
 
         // Check if the customer exists in the 'customer' table
         $findCustomerQuery = "SELECT * FROM customer WHERE customer_email='" . $customer_email . "'";
         $results = mysqli_query($conn, $findCustomerQuery);
 
         if ($results) {
             $numRecords = mysqli_num_rows($results);
 
             if ($numRecords != 0) // Found a match with the customer_email
             {
                 // Need to verify the customer - check the password
                 $row = mysqli_fetch_array($results);
                 $hashedPassword = $row['customer_password'];
 
                 $passwordsAreTheSame = password_verify($customer_password, $hashedPassword);
 
                 if ($passwordsAreTheSame == true) {
                     // Store customer information in session variables
                     $_SESSION['customer_id'] = $row['customer_id'];
                     $_SESSION['customer_email'] = $row['customer_email'];
                     $_SESSION['customer_name'] = $row['customer_name'];
 
                     echo "<p>Passwords match!</p>";
                 } else {
                     echo "<p>Email exists, but the Password does not match the stored password.</p>";
                 }
             } else {
                 echo "<p>This email does not exist in the table.</p>";
 
                 // Insert data into the 'customer' table
                 $hashedPassword = password_hash($customer_password, PASSWORD_DEFAULT);
                 $customer_name = ($_POST["customer_name"]);
                 $customer_phone = ($_POST["customer_phone"]);
 
                 $insertQuery = "INSERT INTO customer (customer_email, customer_password, customer_name, customer_phone) 
                 VALUES ('$customer_email', '$hashedPassword', '$customer_name', '$customer_phone')";
 
                 if (mysqli_query($conn, $insertQuery)) {
                     // Insertion successful
                     echo "<p>New customer added</p>";
                 } else {
                     echo "<p>Table query failed: " . mysqli_error($conn) . "</p>";
                 }
             }
         } else {
             echo "<p>Error locating customer details</p>";
         }
     }
 
     // Close the database connection
     mysqli_close($conn);
     ?>
</body>
</html>
