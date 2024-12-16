<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SeKAD</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-box">
        <a href="index" class="logo logo-admin">
            <img src="img/logo-sm-dark.png" height="50" alt="logo" class="auth-logo">
        </a>
        <h2>SeKAD</h2>
        <p>Forgot Password</p>

        <form action="password/email" method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <button type="submit" class="btn-login">Reset Password</button>
        </form>

        <a href="login.blade.php">Log In</a>
    </div>
</body>

</html>
