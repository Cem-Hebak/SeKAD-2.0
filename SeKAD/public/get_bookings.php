<?php
// Include the database connection
include 'db_connection.php';

try {
    // Retrieve venue ID from the request (if provided)
    $venueId = isset($_GET['venue_id']) ? intval($_GET['venue_id']) : null;

    // Base query
    $query = "
        SELECT 
            booking.start_time, 
            booking.end_time, 
            booking.Subject,
            booking.booked_by, 
            venue.venue_name 
        FROM booking
        JOIN venue ON booking.venue_id = venue.id
    ";

    // Add condition for venue filter if applicable
    if ($venueId) {
        $query .= " WHERE venue.id = :venueId";
    }

    $stmt = $pdo->prepare($query);

    // Bind parameter if venueId is provided
    if ($venueId) {
        $stmt->bindParam(':venueId', $venueId, PDO::PARAM_INT);
    }

    $stmt->execute();

    // Fetch and format events
    $events = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $startTime = date("g a", strtotime($row['start_time'])); // Format time as '9 am'
        $endTime = date("g a", strtotime($row['end_time']));     // Format time as '5 pm'

        $events[] = [
            'title' => htmlspecialchars($row['Subject'], ENT_QUOTES, 'UTF-8'),
            'start' => $row['start_time'],
            'end'   => $row['end_time'],
            'extendedProps' => [
                'venue' => htmlspecialchars($row['venue_name'], ENT_QUOTES, 'UTF-8'),
                'booked_by' => htmlspecialchars($row['booked_by'], ENT_QUOTES, 'UTF-8'), // Move booked_by here
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
