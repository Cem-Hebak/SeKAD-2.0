<?php
    // Include the database connection
    include 'db_connection.php';

    try {
        // Query to get booking dates and details
        $stmt = $pdo->query("SELECT start_time, end_time, Subject FROM booking");
        $bookings = $stmt->fetchAll();

        // Format data for FullCalendar
        $events = [];
        foreach ($bookings as $booking) {
            $events[] = [
                'title' => $booking['Subject'],
                'start' => $booking['start_time'],
                'end'   => $booking['end_time'],
            ];
        }

        // Return as JSON
        header('Content-Type: application/json');
        echo json_encode($events);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch bookings: ' . $e->getMessage()]);
    }
?>
