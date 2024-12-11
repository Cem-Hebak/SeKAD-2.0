<?php
include("db_connection.php"); // Include your database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id']; // User ID
    $class = $_POST['class']; // Selected class

    try {
        // Update the user's class in the database
        $stmt = $pdo->prepare("UPDATE users SET class = ? WHERE id = ?");
        $stmt->execute([$class, $user_id]);

        // Redirect back to the profile or table page with a success message
        header("Location: profile.php?message=Class updated successfully");
        exit();
    } catch (PDOException $e) {
        die("Error updating class: " . $e->getMessage());
    }
} else {
    // Redirect back if the request method is not POST
    header("Location: profile.php");
    exit();
}
?>
