<?php
include("db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_ids = $_POST['user_ids']; // List of user IDs passed
    $attendance = isset($_POST['attendance']) ? $_POST['attendance'] : [];
    $current_date = $_POST['date'] ?? date('Y-m-d'); // Selected date or today

    try {
        foreach ($user_ids as $user_id) {
            $present = isset($attendance[$user_id]) ? 1 : 2; // 1 = present, 2 = absent

            // Fetch the student's details from `biodata_stud` and `users`
            $stmt = $pdo->prepare("
                SELECT b.id, b.name, b.class, u.ic_number, a.present
                FROM biodata_stud b
                JOIN users u ON b.name = u.name
                LEFT JOIN attendance a ON a.user_id = u.id AND a.date = ?
                WHERE b.class = ? AND u.role = 'Student'
            ");
            $stmt->execute([$user_id]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($student) {
                // Insert or Update attendance
                $insertStmt = $pdo->prepare("
                    INSERT INTO attendance (user_id, name, ic_number, date, present, class, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                        present = VALUES(present),
                        updated_at = NOW(),
                        class = VALUES(class)
                ");
                $insertStmt->execute([
                    $user_id,
                    $student['name'],
                    $student['ic_number'],
                    $current_date,
                    $present,
                    $student['class']
                ]);
            }
        }

        // Redirect back with success message
        header("Location: attendanceRecord1.blade.php?message=Attendance updated successfully");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}