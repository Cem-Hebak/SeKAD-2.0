<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "admin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get attendance data from the request
$attendanceData = json_decode(file_get_contents("php://input"), true);

if ($attendanceData) {
    foreach ($attendanceData as $attendance) {
        $studentId = $attendance['id'];
        $name = $attendance['name'];
        $icNumber = $attendance['ic_number'];
        $present = $attendance['present'] ? 1 : 0;

        // Insert attendance record
        $sql = "INSERT INTO attendance_records (student_id, name, ic_number, present, timestamp)
                VALUES ($studentId, '$name', '$icNumber', $present, NOW())";

        if (!$conn->query($sql)) {
            echo json_encode(["status" => "error", "message" => $conn->error]);
            $conn->close();
            exit();
        }
    }

    echo json_encode(["status" => "success", "message" => "Attendance saved successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "No data received."]);
}

$conn->close();
?>
