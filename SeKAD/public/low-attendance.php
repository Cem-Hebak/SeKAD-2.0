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
    $absentValues = [2, 3, 5, 6, 7];
    $attendanceThreshold = 75; // Threshold percentage for warnings

    // Get the logged-in student's IC number from the session
    $loggedInICNumber = $_SESSION['ic_number'];

    // Query to fetch attendance summary for the logged-in student
    $summaryQuery = "SELECT ic_number, name, 
                            COUNT(CASE WHEN present IN (" . implode(',', $presentValues) . ") THEN 1 END) AS total_attendances,
                            COUNT(CASE WHEN present IN (" . implode(',', $absentValues) . ") THEN 1 END) AS total_absences,
                            COUNT(*) AS total_records
                     FROM attendance
                     WHERE ic_number = :ic_number
                     GROUP BY ic_number, name";

    // Query to fetch absence details for the logged-in student
    $absenceDetailsQuery = "SELECT date, present, class
                             FROM attendance
                             WHERE ic_number = :ic_number AND present IN (" . implode(',', $absentValues) . ")
                             ORDER BY date ASC";

    // Prepare and execute the summary query
    $stmt = $pdo->prepare($summaryQuery);
    $stmt->execute(['ic_number' => $loggedInICNumber]);
    $summaryResults = $stmt->fetchAll();

    // Prepare and execute the absence details query
    $absenceStmt = $pdo->prepare($absenceDetailsQuery);
    $absenceStmt->execute(['ic_number' => $loggedInICNumber]);
    $absenceDetails = $absenceStmt->fetchAll();

    // Output attendance summary table
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

    foreach ($summaryResults as $row) {
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

    // Output absence details table
    echo "<h3 style='text-align:center;'>Absence Details</h3>";
    echo "<table>";
    echo "<tr>
            <th>Date</th>
            <th>Class</th>
            <th>Reason</th>
          </tr>";

    foreach ($absenceDetails as $absence) {
        $date = escape($absence['date']);
        $class = escape($absence['class'] ?: 'N/A');
        $reason = '';

        switch ($absence['present']) {
            case 2: $reason = 'Absence without proof'; break;
            case 3: $reason = 'Proof of absence is pending'; break;
            case 5: $reason = 'Absence due to family matter'; break;
            case 6: $reason = 'Absence due to natural disasters'; break;
            case 7: $reason = 'Other (counted as absence)'; break;
        }

        echo "<tr>
                <td>{$date}</td>
                <td>{$class}</td>
                <td>{$reason}</td>
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
