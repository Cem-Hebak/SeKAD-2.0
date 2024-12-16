<?php
// Start the session to access session variables
session_start();

// Include database connection
require_once 'db_connection.php';

// Ensure that IC number is stored in the session
if (isset($_SESSION['ic_number'])) {
    $ic_number = $_SESSION['ic_number'];  // Get IC number from session
} else {
    // Handle the case where the IC number is not found in session
    echo "IC number not found in session.";
    exit;
}

// Prepare the query to get the total days and attendance count based on IC number
$sql_attendance = "SELECT COUNT(*) AS total_days, SUM(present) AS attend
                   FROM attendance
                   WHERE ic_number = ?
                   GROUP BY ic_number";

try {
    // Execute the query
    $stmt = $pdo->prepare($sql_attendance);
    $stmt->execute([$ic_number]);

    // Fetch the results
    $attendance = $stmt->fetch();
    
    // Debug output for checking query result
    var_dump($attendance);  // Check if any results are returned

    // If attendance data exists for the student
    if ($attendance) {
        $total_days = $attendance['total_days'];
        $attend = $attendance['attend'];
        
        // Calculate absence and attendance percentage
        $absence = $total_days - $attend;
        $attendance_percentage = ($total_days > 0) ? ($attend / $total_days) * 100 : 0;
        
        // Check if attendance is below the threshold (e.g., 75%)
        $low_attendance = ($attendance_percentage < 75);

        // Output the data
        echo "<h2>Attendance Report for IC Number: $ic_number</h2>";
        echo "<p>Total Attendance Days: $total_days</p>";
        echo "<p>Days Present: $attend</p>";
        echo "<p>Days Absent: $absence</p>";
        echo "<p>Attendance Percentage: " . number_format($attendance_percentage, 2) . "%</p>";

        // Display message if attendance is low
        if ($low_attendance) {
            echo "<p style='color: red; font-weight: bold;'>Warning: Your attendance is below 75%! Please attend more classes.</p>";
        } else {
            echo "<p style='color: green; font-weight: bold;'>Great job! Your attendance is above 75%.</p>";
        }
    } else {
        echo "<p>No attendance records found for this student (IC Number: $ic_number).</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
