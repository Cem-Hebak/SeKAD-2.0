<?php
// Include the database connection
include("db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $event_name = $_POST['event_name'] ?? null;
    $pic_name = $_POST['pic_name'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $start_date = $_POST['start_date'] ?? null;
    $start_time = $_POST['start_time'] ?? null;
    $finish_date = $_POST['finish_date'] ?? null;
    $finish_time = $_POST['finish_time'] ?? null;
    $description = $_POST['description'] ?? null;

    // Handle file upload
    $posterPath = null;  // Initialize the variable for the poster image path
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/eventPic/';

        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);  // Create with write permissions
        }

        $fileName = time() . '_' . basename($_FILES['poster']['name']);
        $filePath = $uploadDir . $fileName;

        // Move the uploaded file to the designated directory
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $filePath)) {
            $posterPath = 'eventPic/' . $fileName;  // Set the correct file path
        } else {
            echo "File upload failed!";
            exit;
        }
    }

    // Insert into the database
    try {
        $stmt = $pdo->prepare("
            INSERT INTO events (event_name, pic_name, phone_number, start_date, start_time, finish_date, finish_time, description, poster_path, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        // Execute the statement with the data
        $stmt->execute([
            $event_name,
            $pic_name,
            $phone_number,
            $start_date,
            $start_time,
            $finish_date,
            $finish_time,
            $description,
            $posterPath,  // Correctly inserting the path of the uploaded poster image
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);

        // Redirect to a success page
        header("Location: event.blade.php?message=Event submitted successfully!");
        exit();
    } catch (PDOException $e) {
        // In case of error, display the error message
        die("Error: " . $e->getMessage());
    }
} else {
    // If not a POST request, redirect to the form page
    header("Location: event.blade.php");
    exit();
}
?>
