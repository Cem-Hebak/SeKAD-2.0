<?php
session_start(); // Start the session
include('db_connection.php'); // Include database connection

    
 $role = htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8');


?>
<!-- include("db_connection.php"); -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="register-box">
        <h2>SeKAD Register New Venue</h2>
        <p>Please fill in the form to create a venue.</p>
        <form class="form-container" action="RegisterVenueHandling.blade.php" method="POST" enctype="multipart/form-data">
            <!-- Venue Details -->
            <div class="form-column">
                <h3>Venue Details</h3>
                <label for="venue_name">Venue Name:</label>
                <input type="text" id="venue_name" name="venue_name" required>

                <label for="venue_picture">Venue Picture:</label>
                <input type="file" id="venue_picture" name="venue_picture" accept=".jpg, .jpeg, .png" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-register full-width">Register</button>
        </form>
    </div>
</body>
</html>

