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

        <form action="forgot_password_check.blade.php" method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            <button type="submit" name="forgot" class="btn-login">Reset Password</button>
        </form>

        <a href="login.blade.php">Log In</a>
    </div>

    <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en', // Default language of your website
            includedLanguages: 'en,ms', // Languages to include (English and Bahasa Melayu)
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>
