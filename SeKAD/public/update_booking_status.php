<?php
// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database credentials
    $dbHost = 'localhost'; // Database host
    $dbName = 'admin'; // Database name
    $dbUser = 'root'; // Database username
    $dbPass = ''; // Database password

    // Set the response header to JSON
    header('Content-Type: application/json');

    try {
        // Create a PDO instance
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get input data from POST request
        $bookingId = filter_input(INPUT_POST, 'booking_id', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        // Validate inputs
        if ($bookingId === null || $bookingId === false || $status === null || $status === false) {
            echo json_encode(['success' => false, 'error' => 'Invalid input data.']);
            exit;
        }

        // Check if status is for deletion
        if ($status === 4) {
            $stmt = $pdo->prepare("DELETE FROM booking WHERE id = :id");
            $stmt->bindParam(':id', $bookingId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Booking deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to delete booking.']);
            }
            exit;
        }

        // Handle status updates
        $stmt = $pdo->prepare("UPDATE booking SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $bookingId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update the booking status.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>