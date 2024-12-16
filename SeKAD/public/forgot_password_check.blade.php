<?php
// Include the PDO database connection
include 'db_connection.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['forgot'])) {
    // Validate POST data
    function validate($data) {
        return htmlspecialchars(trim($data));
    }

    // Validate and fetch email
    $email = validate($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>
            alert("Invalid email address!");
            window.location.replace("password_reset.blade.php");
        </script>';
        exit();
    }

    // Fetch user details using PDO
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch();

    if ($row) {
        $username = $row['name'];

        // Generate a random 8-character password
        $pass = bin2hex(openssl_random_pseudo_bytes(4));

        // Mail the password to the user using PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'sekadinfo@gmail.com';
            $mail->Password = 'kzik yuvr gklw tukr';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('sekadinfo@gmail.com', 'SeKAD Support');
            $mail->addAddress($row['email']);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Temporary Password for Login to Dashboard System';
            $mail->Body = "Temporary Password for <strong>{$username}</strong>: <strong>{$pass}</strong>";
            $mail->isHTML(true);
            $mail->send();

            // Store the hashed password in the database
            $tempPassword = password_hash($pass, PASSWORD_BCRYPT);
            $stmt2 = $pdo->prepare("UPDATE `users` SET `password` = ? WHERE `email` = ?");
            $stmt2->execute([$tempPassword, $email]);

            if ($stmt2->rowCount() > 0) {
                echo '<script>
                    alert("Temporary password has been sent to your registered email address. Please change it after logging in!");
                    window.location.replace("index.blade.php");
                </script>';
            } else {
                echo '<script>
                    alert("Failed to update password. Please try again.");
                    window.location.replace("password_reset.blade.php");
                </script>';
            }
        } catch (Exception $e) {
            echo '<script>
                alert("Mailer Error: ' . $mail->ErrorInfo . '");
                window.location.replace("password_reset.blade.php");
            </script>';
        }
    } else {
        echo '<script>
            alert("Unregistered Credentials");
            window.location.replace("password_reset.blade.php");
        </script>';
    }
} else {
    header('Location: index.blade.php');
}
