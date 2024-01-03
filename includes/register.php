<?php
/*
    Register backend page.
*/
$first_name = "";
$last_name = "";
$email = "";
$password = "";
$repassword = "";
$phone = "";
$street = "";
$suburb = "";
$postcode = "";
$state = "";

$firstNameErr = "";
$lastNameErr = "";
$emailErr = "";
$phoneErr = "";

$addressErr = "";
$streetErr = "";
$suburbErr = "";
$postcodeErr = "";
$stateErr = "";

$passwordErr = "";
$repasswordErr = "";
$errorMessage = "";
$emailRegisterErr = "";
$invalidData = false;

// Validate fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["reset"])) {
        header("Refresh:0");
        exit();
    }

    $first_name = checkInput($_POST["first_name"]);
    $last_name = checkInput($_POST["last_name"]);
    $email = checkInput($_POST["email"]);
    $phone = checkInput($_POST["phone"]);
    $password = checkInput($_POST["password"]);
    $repassword = checkInput($_POST["repassword"]);
    $street = checkInput($_POST["street"]);
    $suburb = checkInput($_POST["suburb"]);
    $postcode = checkInput($_POST["postcode"]);
    $state = checkInput($_POST["state"]);

    $address = $street . ', ' . $suburb . ', ' . $postcode . ', ' . $state;


    if (empty($street) || empty($suburb) || empty($postcode) || empty($state)) {
        //$errorMessage = "The * Required Field(s) missing.";
        $lastNameErr = "Last Name Required.";
        $addressErr = "\nStreet, Suburb, Postcode, and State are required.";
        $invalidData = true;
    } else {
        $addressErr = "";
    }

    if (empty($first_name)){
        $firstNameErr = "First Name Required";

    } else{
        $firstNameErr = "";

    }
    if (empty($last_name)){
        $lastNameErr = "Last Name Required.";
    } else{
        $lastNameErr = "";

    }

    if (empty($email)) {
        $emailErr = "Email is Required.";
        $invalidData = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid Email Format.";
        $invalidData = true;
    } else {
        $emailErr = "";
    }

    if (empty($password)) {
        $passwordErr = "Password is Required.";
        $invalidData = true;
    }

    if (empty($repassword)) {
        $repasswordErr = "Re-password is Required.";
        $invalidData = true;
    } elseif (!empty($password) && $password != $repassword) {
        $repasswordErr = "Passwords do not match. Try Again.";
        $invalidData = true;
    } else {
        $passwordErr = "";
        $repasswordErr = "";
    }

    if (empty($phone)) {
        $phoneErr = "Phone number is required.";
        $invalidData = true;
    } elseif (!ctype_digit($phone)) {
        $phoneErr = "Phone number must only contain numbers.";
        $invalidData = true;
    } else {
        $phoneErr = "";
    }
    if (!$invalidData) {
        // Connect to the server and add a new record
        require_once('../includes/conn_ecommercedb.php'); // Check the filename and path
    
        // Check if the email is already registered
        $check_query = "SELECT COUNT(*) FROM customer WHERE customer_email = ?";
        $stmt = $mysqli->prepare($check_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email_count);
        $stmt->fetch();
        $stmt->close();
    
        if ($email_count > 0) {
            $emailRegisterErr = "Email address is already registered...!!!! Go back and Try again...!";
        } else {
            // Hash the password securely using PASSWORD_DEFAULT Hash
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
            // Prepare and execute the SQL query using prepared statement
            $query = "INSERT INTO customer (customer_email, customer_password, customer_name, customer_phone, customer_address) VALUES (?, ?, CONCAT(?, ' ', ?), ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ssssss", $email, $hashed_password, $first_name, $last_name, $phone, $address);
    
    
            if ($stmt->execute()) {
                header('Location: success_page.php');
                exit();
                // echo "<p><b>Registration Success!</b></p>";
                // echo "<p><b>Please standby....</b></p>";
                // echo "<script>
                //         setTimeout(function() {
                //             window.location.href = '../loginform.php';
                //         }, 5000); // 5000 milliseconds = 5 seconds
                //       </script>";
                // Send a confirmation email
                // $message = "Thank you for registering with us\nYour Details are:\nName: $first_name $last_name\nEmail: $email\nPhone: $phone\n";
                // mail($email, "Website Email", $message);
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }
            
            $stmt->close();
        }
    
        mysqli_close($mysqli);
    }
    
}

function checkInput($inputData)
{
    $inputData = trim($inputData);
    $inputData = stripslashes($inputData);
    $inputData = htmlspecialchars($inputData);
    return $inputData;
}
?>