<?php
include("db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_ids = $_POST['user_ids']; // All user IDs
    $attendance = isset($_POST['attendance']) ? $_POST['attendance'] : [];

    $current_date = date('Y-m-d'); // Today's date

    try {
        foreach ($user_ids as $user_id) {
            $present = isset($attendance[$user_id]) ? 1 : 2; // Check if user ID is checked (present)

          
            
                // Fetch the user's name and IC number
                $stmt = $pdo->prepare("SELECT id, name, ic_number FROM users WHERE id = ?");
                $stmt->execute([$user_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Insert or update attendance using user_id (only if present)
                    $insertStmt = $pdo->prepare("
                        INSERT INTO attendance (user_id, date, present, name, ic_number)
                        VALUES (?, ?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE present = VALUES(present)
                    ");
                    $insertStmt->execute([
                        $user['id'],  // Use user_id here
                        $current_date,
                        $present,
                        $user['name'],
                        $user['ic_number']
                    ]);
                
            }
        }

        // Redirect back with success message
        header("Location: attendanceRecord1.blade.php?message=Attendance updated successfully");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: attendanceRecord1.blade.php");
    exit();
}
