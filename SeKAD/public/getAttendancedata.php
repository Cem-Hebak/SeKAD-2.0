<?php
require 'db_connection.php';

try {
    // Query to count attendance statuses grouped by class and date
    $stmt = $pdo->prepare("
        SELECT 
            name,
            class,
            DATE_FORMAT(date, '%Y-%m-%d') AS date,
            present,
            COUNT(*) AS count
        FROM attendance
        GROUP BY class, date, present
        ORDER BY class, date
    ");
    $stmt->execute();

    // Fetch the results
    $rawResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Structure the results
    $structuredData = [];
    foreach ($rawResults as $row) {
        $class = $row['class'];
        $date = $row['date'];
        $status = intval($row['present']);
        $count = intval($row['count']);

        // Initialize class and date arrays if not already done
        if (!isset($structuredData[$class])) {
            $structuredData[$class] = [];
        }
        if (!isset($structuredData[$class][$date])) {
            $structuredData[$class][$date] = [
                'attend' => 0,
                'absence' => 0,
                'pending' => 0,
                'medical' => 0
            ];
        }

        // Map the attendance status to the correct category
        if ($status === 1) {
            $structuredData[$class][$date]['attend'] = $count;
        } elseif ($status === 2) {
            $structuredData[$class][$date]['absence'] = $count;
        } elseif ($status === 3) {
            $structuredData[$class][$date]['pending'] = $count;
        } elseif ($status === 4) {
            $structuredData[$class][$date]['medical'] = $count;
        }
    }

    // Return the structured data as JSON
    echo json_encode($structuredData);
} catch (PDOException $e) {
    // Provide detailed error messages in development (avoid exposing in production)
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch attendance data.', 'details' => $e->getMessage()]);
}
?>
