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
        // Create PDO instance
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get input data from POST request
        $bookingId = $_POST['booking_id'] ?? null;
        $status = $_POST['status'] ?? null;

        // Validate inputs
        if ($bookingId === null || $status === null) {
            echo json_encode(['success' => false, 'error' => 'Invalid input data.']);
            exit;
        }

        // Handle deletion if status is 4
        if ((int) $status === 4) {
            $stmt = $pdo->prepare("DELETE FROM booking WHERE booking_id = :booking_id");
            $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Booking deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to delete booking.']);
            }
            exit;
        }

        // Handle status updates
        $stmt = $pdo->prepare("UPDATE booking SET status = :status WHERE booking_id = :booking_id");
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);

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