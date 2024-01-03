<!DOCTYPE html>

<head>
    <html lang="en">
    <meta charset="UTF-8">
    <title>Staff Login Form</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
    <a href="loginform.php">Home</a>
    <h1>CHOCOLATE FACTORY</h1>
    </header>

    <main>
        <div class="forms-container">
            <?php
            // include('includes/logindb.php');
            include('includes/login_error.php');
            ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Customer Login</h2>

                <label for="email">Email:</label>
                <input type="text" placeholder="Enter Email" name="customer_email" id="customer_email" value="<?php echo $customer_email; ?>"/>
                <span class="error">* <?php echo $emailErr; ?></span><br /><br />
                <label for="password"><b>Password:</b></label>
                <input type="password" placeholder="Enter Password" name="customer_password" id="customer_password" value="<?php echo $customer_password; ?>"/>

                <span class="error">* <?php echo $passwordErr; ?></span><br /><br />

                <input type="submit" value="Submit" name="submit" title="Submit Button" />
                <input type="submit" value="Reset" name="reset" title="Reset Button" />

                <label><strong><a href="recover_password.html">Forgot your password?</a></strong></label>
            </form>


            <form method="POST">
                <h2>New Customers</h2>
                <a href="Pages/register_page.php" class="register-account">Create An Account</a>
            </form>
    </div>
    
</main>
    <footer>
        <?php
        include('includes/footer.php');
        ?>
    </footer>
</body>

</html>