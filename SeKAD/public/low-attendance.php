<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['ic_number'])) {
    die("You must log in to view this page.");
}

// Assuming you have a database connection here
include 'db_connection.php'; // Include your DB connection file

try {
    // Get the logged-in student's IC number from the session
    $loggedInICNumber = $_SESSION['ic_number'];

    // Query to fetch attendance records for the logged-in student only
    $query = "SELECT ic_number, name, 
                     COUNT(CASE WHEN present IN (1, 4) THEN 1 END) AS total_attendances,
                     COUNT(CASE WHEN present IN (2, 3) THEN 1 END) AS total_absences,
                     COUNT(*) AS total_records
              FROM attendance
              WHERE ic_number = :ic_number
              GROUP BY ic_number, name";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute(['ic_number' => $loggedInICNumber]);
    $results = $stmt->fetchAll();

    // Display results in an HTML table
    echo "<h2>My Attendance Report</h2>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>IC Number</th>
            <th>Student Name</th>
            <th>Total Attendances</th>
            <th>Total Absences</th>
            <th>Attendance Percentage</th>
            <th>Status</th>
          </tr>";

    foreach ($results as $row) {
        $ic_number = $row['ic_number'];
        $studentName = $row['name'];
        $totalAttendances = $row['total_attendances'];
        $totalAbsences = $row['total_absences'];
        $totalRecords = $row['total_records'];

        // Calculate attendance percentage
        $attendancePercentage = ($totalRecords > 0) ? ($totalAttendances / $totalRecords) * 100 : 0;

        // Check if the attendance percentage is below 75%
        $status = ($attendancePercentage < 75) ? "<span style='color:red;'>Warning</span>" : "Normal";

        echo "<tr>
                <td>{$ic_number}</td>
                <td>{$studentName}</td>
                <td>{$totalAttendances}</td>
                <td>{$totalAbsences}</td>
                <td>" . number_format($attendancePercentage, 2) . "%</td>
                <td>{$status}</td>
              </tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Close the database connection (optional with PDO)
$pdo = null;
?>
