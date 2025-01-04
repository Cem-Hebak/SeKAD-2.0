<?php
include("db_connection.php"); // Include your database connection file
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Initialize messages
    $error_message = '';
    $success_message = '';

    // Get form data
    $student_name = $_POST['student_name'];
    $student_form = $_POST['student_form'];
    $student_class = $_POST['student_class'];
    $session_date = $_POST['session_date'];
    $time_slot = $_POST['time_slot'];
    $session_reason = $_POST['session_reason'];

    try {
        // Check if the time slot on the selected date is already taken
        $stmt = $pdo->prepare("SELECT * FROM counselling_sessions 
                               WHERE session_date = :session_date 
                               AND time_slot = :time_slot");
        $stmt->execute([
            ':session_date' => $session_date,
            ':time_slot' => $time_slot,
        ]);
        $existing_booking = $stmt->fetch();

        if ($existing_booking) {
            // If a conflicting session exists, set an error message
            $_SESSION['error_message'] = "The selected time slot is already taken. Please choose a different time.";
        } else {
            // If no conflict, proceed to insert the booking
            $stmt = $pdo->prepare("INSERT INTO counselling_sessions (student_name, student_form, student_class, time_slot, session_reason, session_date, status) 
                                   VALUES (:student_name, :student_form, :student_class, :time_slot, :session_reason, :session_date, 'Pending')");
            $stmt->execute([
                ':student_name' => $student_name,
                ':student_form' => $student_form,
                ':student_class' => $student_class,
                ':time_slot' => $time_slot,
                ':session_reason' => $session_reason,
                ':session_date' => $session_date,
            ]);

            // Set success message
            $_SESSION['success_message'] = "Booking successful!";
        }
    } catch (PDOException $e) {
        // Handle database errors
        $_SESSION['error_message'] = "An error occurred: " . $e->getMessage();
    }

    // Redirect back to the Blade view
    header("Location: counselStud.blade.php");
    exit();
}
?>