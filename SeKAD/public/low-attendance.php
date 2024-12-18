<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['ic_number'])) {
    die("You must log in to view this page.");
}

// Assuming you have a database connection here
include 'db_connection.php'; // Include your DB connection file

// Escape HTML output function
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

try {
    // Define present and absent values
    $presentValues = [1, 4];
    $absentValues = [2, 3];
    $attendanceThreshold = 75; // Threshold percentage for warnings

    // Get the logged-in student's IC number from the session
    $loggedInICNumber = $_SESSION['ic_number'];

    // Query to fetch attendance records for the logged-in student
    $query = "SELECT ic_number, name, 
                     COUNT(CASE WHEN present IN (" . implode(',', $presentValues) . ") THEN 1 END) AS total_attendances,
                     COUNT(CASE WHEN present IN (" . implode(',', $absentValues) . ") THEN 1 END) AS total_absences,
                     COUNT(*) AS total_records
              FROM attendance
              WHERE ic_number = :ic_number
              GROUP BY ic_number, name";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute(['ic_number' => $loggedInICNumber]);
    $results = $stmt->fetchAll();

    // Output table
    echo "<h2 style='text-align:center;'>My Attendance Report</h2>";
    echo "<style>
            table { width: 80%; margin: auto; border-collapse: collapse; text-align: center; }
            th, td { padding: 10px; border: 1px solid #ddd; }
            th { background-color: #f2f2f2; }
            tr:nth-child(even) { background-color: #f9f9f9; }
            span { font-weight: bold; }
          </style>";

    echo "<table>";
    echo "<tr>
            <th>IC Number</th>
            <th>Student Name</th>
            <th>Total Attendances</th>
            <th>Total Absences</th>
            <th>Attendance Percentage</th>
            <th>Status</th>
          </tr>";

    foreach ($results as $row) {
        $ic_number = escape($row['ic_number']);
        $studentName = escape($row['name']);
        $totalAttendances = $row['total_attendances'];
        $totalAbsences = $row['total_absences'];
        $totalRecords = $row['total_records'];

        // Calculate attendance percentage
        $attendancePercentage = ($totalRecords > 0) ? ($totalAttendances / $totalRecords) * 100 : 0;

        // Determine status
        $status = ($attendancePercentage < $attendanceThreshold) ? 
                  "<span style='color:red;'>Warning</span>" : "Normal";

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
    echo "<p style='text-align:center;'><a href='?logout=true'>Logout</a></p>";

} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$pdo = null; // Close DB connection
?>
