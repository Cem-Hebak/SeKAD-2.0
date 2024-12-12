<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SeKAD</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-box">
        <a href="index" class="logo logo-admin">
            <img src="img/logo-sm-dark.png" height="50" alt="logo" class="auth-logo">
        </a>
        <h2>SeKAD</h2>
        <p>Log In</p>
        
        <!-- Display success message -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Registration successful! Please log in.</div>
        <?php endif; ?>

        <!-- Display error message -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form action="login_handling.blade.php" method="POST">
            <input type="text" name="ic_number" placeholder="IC number" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn-login">Log In</button>
        </form>

        <a href="password_reset.php">Forgot your password?</a>
    </div>
</body>
</html>
