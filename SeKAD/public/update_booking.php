<?php
include("db_connection.php"); // Include your database connection file
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_name = $_POST['student_name'];
    $student_form = $_POST['student_form'];
    $student_class = $_POST['student_class'];
    $session_date = $_POST['session_date'];
    $time_slot = $_POST['time_slot'];
    $session_reason = $_POST['session_reason'];

    // Prepare the SQL statement to insert the booking into the database
    $sql = "INSERT INTO counselling_sessions (student_name, student_form, student_class, time_slot, session_reason, session_date, status) 
            VALUES (:student_name, :student_form, :student_class, :time_slot, :session_reason, :session_date, 'Pending')";

    try {
        // Prepare and execute the statement using PDO
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':student_name', $student_name);
        $stmt->bindParam(':student_form', $student_form);
        $stmt->bindParam(':student_class', $student_class);
        $stmt->bindParam(':session_date', $session_date);
        $stmt->bindParam(':time_slot', $time_slot);
        $stmt->bindParam(':session_reason', $session_reason);
        
        
        // Execute the statement
        $stmt->execute();

        // Redirect to the counselStud.blade.php after successful submission
        header("Location: counselStud.blade.php");
        exit(); // Ensure that the script stops here
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
}
?>