<?php
// Assuming you have a database connection here
include 'db_connection.php'; // Include your DB connection file

try {
    // Query to fetch student attendance records
    $query = "SELECT ic_number, name, 
                     COUNT(CASE WHEN present IN (1, 4) THEN 1 END) AS total_attendances,
                     COUNT(CASE WHEN present IN (2, 3) THEN 1 END) AS total_absences,
                     COUNT(*) AS total_records
              FROM attendance
              GROUP BY ic_number, name";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll();

    // Display results in an HTML table
    echo "<h2>Low Attendance Report</h2>";
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
        $present = ($attendancePercentage < 75) ? "<span style='color:red;'>Warning</span>" : "Normal";

        echo "<tr>
                <td>{$ic_number}</td>
                <td>{$studentName}</td>
                <td>{$totalAttendances}</td>
                <td>{$totalAbsences}</td>
                <td>" . number_format($attendancePercentage, 2) . "%</td>
                <td>{$present}</td>
              </tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Close the database connection (optional with PDO)
$pdo = null;
?>
