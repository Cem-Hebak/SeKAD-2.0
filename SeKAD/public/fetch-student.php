<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentYear = date("Y");
$selectedYear = $_GET['year'] ?? '';
$page = $_GET['page'] ?? 1;
$perPage = $_GET['per_page'] ?? 10;
$offset = ($page - 1) * $perPage;

if ($selectedYear) {
    $sql = "SELECT id, name, ic_number, date_of_birth,
                   (YEAR(CURDATE()) - YEAR(date_of_birth)) AS year_group
            FROM users
            WHERE role = 'student'
              AND (YEAR(CURDATE()) - YEAR(date_of_birth)) = ?
            LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $selectedYear, $offset, $perPage);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    echo json_encode($students);
} else {
    echo json_encode([]);
}


$conn->close();
?>
