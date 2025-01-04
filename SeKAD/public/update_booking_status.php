<?php
// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database credentials
    $dbHost = 'localhost'; // Database host
    $dbName = 'admin'; // Database name
    $dbUser = 'root'; // Database username
    $dbPass = ''; // Database password

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

        // Prepare the SQL query
        $stmt = $pdo->prepare("UPDATE booking SET status = :status WHERE booking_id = :booking_id");

        // Bind parameters
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);

        // Execute the query
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