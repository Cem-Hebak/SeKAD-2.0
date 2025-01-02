<?php
// Ensure the required session or database connections are made
session_start();
include('db_connection.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $venue_name = htmlspecialchars($_POST['venue_name'], ENT_QUOTES, 'UTF-8');
    $capacity = (int) $_POST['capacity'];
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

    // Insert venue details
    try {
        // Insert venue into the database
        $stmt = $pdo->prepare("INSERT INTO venue (venue_name, venue_picture, capacity) VALUES (:venue_name, :venue_picture, :capacity)");
        $stmt->bindParam(':venue_name', $venue_name);
        $stmt->bindParam(':venue_picture', $target_file);
        $stmt->bindParam(':capacity', $capacity);
        $stmt->execute();

        // Get the ID of the newly inserted venue
        $venue_id = $pdo->lastInsertId();
    } catch (PDOException $e) {
        echo "Error inserting venue: " . $e->getMessage();
        exit();
    }

    // Handling the facilities (array of selected facilities)
    $facility_names = $_POST['facility_name'];
    $facility_quantities = $_POST['facility_quantity'];
    $other_facilities = isset($_POST['other_facility_name']) ? $_POST['other_facility_name'] : [];

    // Insert facilities into venue_facilities table
    try {
        for ($i = 0; $i < count($facility_names); $i++) {
            $facility_name = htmlspecialchars($facility_names[$i], ENT_QUOTES, 'UTF-8');
            $quantity = (int) $facility_quantities[$i];

            // Use the other facility name if selected
            if ($facility_name === 'Others' && isset($other_facilities[$i]) && !empty($other_facilities[$i])) {
                $facility_name = htmlspecialchars($other_facilities[$i], ENT_QUOTES, 'UTF-8');
            }

            // Insert facility
            $stmt_facility = $pdo->prepare("INSERT INTO venue_facilities (venue_id, facility_name, quantity) VALUES (:venue_id, :facility_name, :quantity)");
            $stmt_facility->bindParam(':venue_id', $venue_id);
            $stmt_facility->bindParam(':facility_name', $facility_name);
            $stmt_facility->bindParam(':quantity', $quantity);
            $stmt_facility->execute();
        }
    } catch (PDOException $e) {
        echo "Error inserting facilities: " . $e->getMessage();
        exit();
    }

    // Redirect after successful insert
    header("Location: Facility_And_Equipment_Booking_Teacher.blade.php");
    exit();
}
?>
