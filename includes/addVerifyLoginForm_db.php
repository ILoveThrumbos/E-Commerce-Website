<!DOCTYPE html>
<html lang="en">
<head>
    <html lang="en">
    <meta charset="UTF-8">
    <title>Verify login</title>
    <h1> Verify login</h1>
    <link rel="stylesheet" href="../css//contain.css">
</head>

<body>
    <?php
    /*
    Page Name: LoginForm.php
    Date: 18/05/2023
    Author: 
    Purpose: MYSQL database for the login verification, 
    hash() for users and password verify.
    */

    
    $conn = mysqli_connect("localhost:3306", "root", "", "");

    if (mysqli_connect_errno()) {
        echo "<p>Failed to connect to MySQL: " . mysqli_connect_error() . "</p>";
    } else {
        $dbName = "testuserdb";
        $createDB = "CREATE DATABASE IF NOT EXISTS " . $dbName;

        if (!mysqli_query($conn, $createDB)) {
            echo "<p>Could not open the database: " . mysqli_error($conn) . "</p>";
        } else {
            if (!mysqli_select_db($conn, $dbName)) {
                echo "<p>Could not open the database: " . mysqli_error($conn) . "</p>";
            } else {
                $createDB = "CREATE TABLE IF NOT EXISTS users (userName varchar(50) not null primary key ,userPassword varchar(255) not null)";

                if (!mysqli_query($conn, $createDB)) {
                    echo "<p>table query failed: " . mysqli_error($conn) . "</p>";
                } else {
                    $userName = ($_POST["userName"]);
                    $userPassword = ($_POST["userPassword"]);


                    $createDB = "SELECT * FROM users WHERE userName='" . $userName . "'";
                    $results = mysqli_query($conn, $createDB);
                    if ($results) {
                        $numRecords = mysqli_num_rows($results);
                        if ($numRecords != 0) //found a match with the userName
                        {
                            //need to verify user - check the password
                            $row = mysqli_fetch_array($results);
                            $hashedPassword = $row['userPassword'];

                            $passwordsAreTheSame = password_verify($userPassword, $hashedPassword);

                            if ($passwordsAreTheSame == true) {
                                echo "<p>Passwords match!</p>";
                            } else {
                                echo     "<p>Username exists but the Password does not match the stored password.</p>";
                            }
                        } else {
                            echo "<p>This user does not exist in the table.</p>";
                            $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
                            //insert data in the table
                            $insert = "INSERT INTO users(userName, userPassword) VALUES ('$userName', 										
                                    '$hashedPassword')";

                            if (mysqli_query($conn, $insert)) {
                                //update successful
                                echo "<p>New user added</p>";
                            } else {
                                echo "<p>table query failed: " . mysqli_error($conn) . "</p>";
                            }
                        }
                    } else {
                        echo "<p>Error locating customer details</p>";
                    }
                }
            }
        }
    }
    //Close the connection
    mysqli_close($conn);
    ?>



</body>

</html>