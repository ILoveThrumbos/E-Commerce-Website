<?php
$customer_email = "";
$customer_password = "";
$emailErr = "";
$passwordErr = "";
$invalidData = false;

function checkInput($inputData)
{
    $inputData = trim($inputData);
    $inputData = stripslashes($inputData);
    $inputData = htmlspecialchars($inputData);
    return $inputData;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["reset"])) {
        header("Refresh:0");
        exit();
    }
    $customer_email = checkInput($_POST["customer_email"]);
    $customer_password = checkInput($_POST["customer_password"]);

    if ($customer_email == "") {
        $emailErr = "Email must not be blank";
        $invalidData = true;
    } else {
        $emailErr = "";
    }
    if ($customer_password == "") {
        $passwordErr = "Password must not be blank";
        $invalidData = true;
    } else {
        $passwordErr = "";
    }

if (!$invalidData) {
    // Start a session or resume the current session
    session_start();
    
    // Include the database connection file
    require_once('conn_ecommercedb.php');

    // Proceed with a prepared statement for query and login validation
    $query = "SELECT * FROM customer WHERE customer_email = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("s", $customer_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['customer_password'];

            if (password_verify($customer_password, $storedPassword)) {
                $_SESSION['user_id'] = $row['customer_id'];
                $_SESSION['user_email'] = $row['customer_email'];
                $_SESSION['user_name'] = $row['customer_name'];

                // Redirect to a success page
                header('Location: Pages/index.html');
                exit();
            } else {
                $passwordErr = "Password does not match";
                $invalidData = true;
                echo "User-Entered Password: " . $customer_password . "<br>";
                echo "Hashed Password from DB: " . $storedPassword . "<br>";
            }
        } else {
            $emailErr = "Email not found";
            $invalidData = true;
        }

        $stmt->close();
    } else {
        echo "<p>Prepare statement failed: " . $mysqli->error . "</p>";
    }

    $mysqli->close();
}

if ($invalidData == false) {
    // Redirect to a success page
    header('Location: Pages/index.html');
    exit();
}
}


?>
