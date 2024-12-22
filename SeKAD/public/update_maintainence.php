<?php
// Include the database connection file
include("db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $name = $_POST['reporter_name'] ?? null;
    $date_of_reporting = $_POST['report_date'] ?? null;
    $time_of_reporting = $_POST['report_time'] ?? null;
    $date_of_repair_completion = $_POST['repair_date'] ?? null;
    $time_of_repair_completion = $_POST['repair_time'] ?? null;
    $description = $_POST['report_description'] ?? null;

    // Handle file upload
    $picturePath = null;
    if (isset($_FILES['report_image']) && $_FILES['report_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);  // Create with write permissions
        }

        $fileName = time() . '_' . basename($_FILES['report_image']['name']);
        $filePath = $uploadDir . $fileName;

        // Move the uploaded file to the designated directory
        if (move_uploaded_file($_FILES['report_image']['tmp_name'], $filePath)) {
            $picturePath = 'uploads/' . $fileName;
        } else {
            echo "File upload failed!";
            exit;
        }
    }

    // Insert the maintenance report into the database
    try {
        // Prepare the SQL statement to insert data into the `maintenance_reports` table
        $stmt = $pdo->prepare("
            INSERT INTO maintenance_reports (name, date_of_reporting, time_of_reporting, date_of_repair_completion, time_of_repair_completion, picture, description, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        // Execute the statement with the data
        $stmt->execute([
            $name,
            $date_of_reporting,
            $time_of_reporting,
            $date_of_repair_completion,
            $time_of_repair_completion,
            $picturePath,
            $description,
            date('Y-m-d H:i:s'),  // current timestamp for created_at
            date('Y-m-d H:i:s')   // current timestamp for updated_at
        ]);

        // Redirect back with a success message
        header("Location: announce.blade.php?message=Report submitted successfully!");
        exit();
    } catch (PDOException $e) {
        // In case of error, display the error message
        die("Error: " . $e->getMessage());
    }
} else {
    // If not a POST request, redirect to the form page
    header("Location: announce.blade.php");
    exit();
}
?>
