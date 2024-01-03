<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Payment Page</title>
    <style type="text/css">
        .style1 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
        }
    </style>
</head>

<body>
    <h1>Payment Details</h1>
    <p class="style1">Please enter your credit card and shipping details</p>
    <form action="../includes/process_payment.php" method="post" name="process_payment">
        <table style="width: 61%; height: 313px">
            <!-- Existing fields (Name, Email, Address, Card Type, Card Number, Verification Code, Exp. Date) -->
            <tr>
                <td class="style1" style="width: 173px">Name</td>
                <td class="style1">
                    <input name="name" style="width: 240px" type="text" />
                </td>
            </tr>
            <tr>
                <td class="style1" style="width: 173px">Email Address</td>
                <td class="style1"><input name="email" type="text" /></td>
            </tr>
            <tr>
                <td class="style1" style="width: 173px">Shipping Address</td>
                <td class="style1">
                    <textarea name="address" style="width: 205px; height: 91px"></textarea>
                </td>
            </tr>
            <tr>
                <td class="style1" style="width: 173px">Card Type</td>
                <td class="style1">
                    <select name="card_type">
                        <option value="Visa">Visa</option>
                        <option value="Master Card">Master Card</option>
                        <option value="American Express">American Express</option>
                        <option value="Carte Blanche">Carte Blanche</option>
                        <option value="Discover">Discover</option>
                        <option value="Diner's Club">Diner's Club</option>
                        <option value="enRoute">enRoute</option>
                        <option value="JCB">JCB</option>
                        <option value="Solo">Solo</option>
                        <option value="Switch">Switch</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="style1" style="width: 173px">Card Number</td>
                <td class="style1"><input name="card_no" type="text" value="4111 1111 1111 1111" /></td>
            </tr>
            <tr>
                <td class="style1" style="width: 173px">Verification Code</td>
                <td class="style1"><input name="code" type="text" /></td>
            </tr>
            <tr>
                <td class="style1" style="width: 173px">Exp. Date</td>
                <td class="style1"><input name="exp_date" type="text" /></td>
            </tr>
            <!-- Total Amount, Sales Tax, and Shipping Charges -->
            <input type="hidden" name="total_price" value="<?php echo $_SESSION['total_price']; ?>">


            <!-- Submit and Reset buttons -->
            <tr>
                <td class="style1" style="width: 173px">
                    <input name="Submit1" type="submit" value="Submit Order" />
                </td>
                <td class="style1">
                    <input name="Reset1" type="reset" value="Reset" />
                </td>
            </tr>
        </table>
        <p><b><a href="checkout_page.php">Go back to checkout</a></b></p>
    </form>
</body>

</html>