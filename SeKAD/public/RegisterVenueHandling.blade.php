<?php
// Ensure the required session or database connections are made
session_start();
include('db_connection.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $venue_name = htmlspecialchars($_POST['venue_name'], ENT_QUOTES, 'UTF-8');
    $capacity = (int) $_POST['capacity']; // Convert capacity to integer
    $venue_picture = $_FILES['venue_picture']['name'];
    $venue_picture_tmp = $_FILES['venue_picture']['tmp_name'];

    // Check if file upload is valid
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($venue_picture);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate the image file
    if (getimagesize($venue_picture_tmp) === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if file upload is successful
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($venue_picture_tmp, $target_file)) {
            echo "The file " . htmlspecialchars($venue_picture) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Handling the facilities (array of selected facilities)
    $facilities = isset($_POST['facilities']) ? $_POST['facilities'] : [];

    // If "Others" is selected, handle the input for the other facility
    $other_facility = isset($_POST['other_facility']) ? htmlspecialchars($_POST['other_facility'], ENT_QUOTES, 'UTF-8') : '';

    if ($other_facility) {
        $facilities[] = $other_facility; // Add other facility to the list
    }

    // Insert the venue details into the database
    $stmt = $pdo->prepare("INSERT INTO venue (venue_name, venue_picture, capacity) VALUES (:venue_name, :venue_picture, :capacity)");
    $stmt->bindParam(':venue_name', $venue_name);
    $stmt->bindParam(':venue_picture', $target_file); // Use the path to the uploaded picture
    $stmt->bindParam(':capacity', $capacity);
    $stmt->execute();

    // Get the ID of the newly inserted venue
    $venue_id = $pdo->lastInsertId();

    // Insert the selected facilities into a separate table (assuming a 'facility' table exists)
    if (!empty($facilities)) {
        foreach ($facilities as $facility) {
            $stmt_facility = $pdo->prepare("INSERT INTO venue_facilities (venue_id, facility_name) VALUES (:venue_id, :facility_name)");
            $stmt_facility->bindParam(':venue_id', $venue_id);
            $stmt_facility->bindParam(':facility_name', $facility);
            $stmt_facility->execute();
        }
    }

    // Redirect to a confirmation or venue list page after successful registration
    header("Location: Facility_And_Equipment_Booking_Teacher.blade.php"); // Or another page you prefer
    exit();
}
?>
