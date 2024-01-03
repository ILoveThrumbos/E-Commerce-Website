<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
  <header>
    <a href="../loginform.php">Home</a>
    <h1>CHOCOLATE FACTORY</h1>
  </header>
  <nav>
    <h1>Registration Page</h1>
  </nav>
  <p align="center">Please complete the following form and submit to Register</p>
  <main>
    <div class="forms-container">
      <?php
      include('../includes/register.php');
      ?>
      <form name="form1" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table width="495" height="300" border="0">
          <span class="error"> <?php echo $errorMessage; ?></span>
          <tr>
            <td width="163">First Name </td>
            <td width="322">
              <input name="first_name" type="text" id="first_name" size="15" maxlength="30" value="<?php echo htmlspecialchars($first_name); ?>">
              <span class="error">* <?php echo $firstNameErr; ?></span>
            </td>
          </tr>
          <tr>
            <td>Last Name </td>
            <td>
              <input name="last_name" type="text" id="last_name" size="20" maxlength="60" value="<?php echo htmlspecialchars($last_name); ?>">
              <span class="error">* <?php echo $lastNameErr; ?></span>
            </td>
          </tr>
          <tr>
            <td>Email</td>
            <td>
              <input name="email" type="text" id="email" size="30" maxlength="60" value="<?php echo htmlspecialchars($email); ?>">
              <span class="error">* <?php echo $emailErr; ?></span>
            </td>
          </tr>
          <tr>
            <td>Tel. Number </td>
            <td>
              <input name="phone" type="text" id="phone" size="20" maxlength="10" value="<?php echo htmlspecialchars($phone); ?>">
              <span class="error">* <?php echo $phoneErr; ?></span>
            </td>
          </tr>
          <tr>
            <td>Shipping Address</td>
            <td>
              <input placeholder="Street" name="street" id="street" size="20" maxlength="30" value="<?php echo htmlspecialchars($street); ?>">
              <input placeholder="Suburb" name="suburb" id="suburb" size="20" maxlength="30" value="<?php echo htmlspecialchars($suburb); ?>">
              <input placeholder="Postcode" name="postcode" id="postcode" size="20" maxlength="30" value="<?php echo htmlspecialchars($postcode); ?>">
              <input placeholder="State" name="state" id="state" size="20" maxlength="30" value="<?php echo htmlspecialchars($state); ?>">
              <span class="error">* <?php echo $addressErr; ?></span>
            </td>

          </tr>
          <tr>
            <td>Password</td>
            <td>
              <input name="password" type="password" id="password" size="15" maxlength="64">
              <span class="error">* <?php echo $passwordErr; ?></span>
            </td>
          </tr>
          <tr>
            <td height="29">Re-type Password </td>
            <td>
              <input name="repassword" type="password" id="repassword" size="15" maxlength="64">
              <span class="error">* <?php echo $repasswordErr; ?></span>
            </td>
          </tr>
          <tr>
            <td height="40"><input type="submit" name="Submit" value="Submit"></td>
            <td><input type="submit" name="reset" value="Reset"></td>
            <span class="error"> <?php echo $emailRegisterErr; ?></span>
          </tr>
        </table>
      </form>
    </div>
    <div class="forms-container">
      <a href="../loginform.php">Click here to return to login.</a>
    </div>
  </main>
  <footer>
    <?php
    include('../includes/footer.php');
    ?>
  </footer>
</body>

</html>