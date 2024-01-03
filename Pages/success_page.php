<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration Successful. Please wait while we process the registration...</title>
</head>

<body>
    <p><b>Registration Success!</b></p>
    <p><b>Please standby as we redirect you....</b></p>
    <script>
        setTimeout(function() {
            window.location.href = '../loginform.php';
        }, 5000); // 5000 milliseconds = 5 seconds
    </script>
    <p>If you are not redirected, <a href="../loginform.php">click here</a>.</p>
</body>

</html>
