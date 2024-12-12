<?php
include ("db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ic_number = $_POST['ic_number'];
    $password = $_POST['password'];

    try {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE ic_number = ?");
        $stmt->execute([$ic_number]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables for the logged-in user
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['mobilenumber'] = $user['mobilenumber'];
            $_SESSION['emergencymobilenumber'] = $user['emergencymobilenumber'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['class'] = $user['class'];
            $_SESSION['avatar'] = $user['avatar'];
            $_SESSION['date_of_birth'] = $user['date_of_birth'];
            $_SESSION['gender'] = $user['gender'];
            $_SESSION['ic_number'] = $user['ic_number'];
            $_SESSION['nationality'] = $user['nationality'];
            $_SESSION['address'] = $user['address'];
            $_SESSION['fname'] = $user['fname'];
            $_SESSION['fcontact'] = $user['fcontact'];
            $_SESSION['foccupation'] = $user['foccupation'];
            $_SESSION['mname'] = $user['mname'];
            $_SESSION['mcontact'] = $user['mcontact'];
            $_SESSION['moccupation'] = $user['moccupation'];
            $_SESSION['gname'] = $user['gname'];
            $_SESSION['gcontact'] = $user['gcontact'];
            $_SESSION['goccupation'] = $user['goccupation'];
            $_SESSION['blood_type'] = $user['blood_type'];
            $_SESSION['allergies'] = $user['allergies'];
            // Redirect to home page
            header("Location: index.blade.php");
            exit();
        } else {
            // Redirect back to login with error message
            header("Location: login.php?error=Invalid IC number or password");
            exit();
        }
    } catch (PDOException $e) {
        die("Error during login: " . $e->getMessage());
    }
}
?>
