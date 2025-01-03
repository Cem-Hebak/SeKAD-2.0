<?php
// Include the database connection
include 'db_connection.php';

try {
    // Query to fetch booking data with venue details
    $stmt = $pdo->query("
        SELECT 
            booking.start_time, 
            booking.end_time, 
            booking.Subject, 
            venue.venue_name 
        FROM booking
        JOIN venue ON booking.venue_id = venue.id
    ");

    // Fetch and format events
    $events = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $events[] = [
            'title' => htmlspecialchars($row['Subject'], ENT_QUOTES, 'UTF-8'),
            'start' => $row['start_time'],
            'end'   => $row['end_time'],
            'extendedProps' => [
                'venue' => htmlspecialchars($row['venue_name'], ENT_QUOTES, 'UTF-8'),
            ],
        ];
    }

    // Return events as JSON
    header('Content-Type: application/json');
    echo json_encode($events, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    // Return error response if query fails
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch bookings: ' . $e->getMessage()]);
}
