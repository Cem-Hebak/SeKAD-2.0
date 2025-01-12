<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the two latest maintenance reports
$sql = "SELECT name, date_of_reporting, date_of_repair_completion, description FROM maintenance_reports ORDER BY created_at DESC LIMIT 2";
$result = $conn->query($sql);

$reports = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
}

$conn->close();
?>
