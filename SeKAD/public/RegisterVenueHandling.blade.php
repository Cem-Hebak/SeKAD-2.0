<?php
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $venue_name = htmlspecialchars($_POST['venue_name'], ENT_QUOTES, 'UTF-8');

    // Handle picture upload
    $venue_picture = null;
    if (isset($_FILES['venue_picture']) && $_FILES['venue_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadsDir = 'uploads/';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0777, true); // Create the uploads directory if it doesn't exist
        }

        $fileName = basename($_FILES['venue_picture']['name']);
        $fileTmpPath = $_FILES['venue_picture']['tmp_name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Convert to lowercase

        // Validate file type
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $venue_picture = $uploadsDir . uniqid() . '.' . $fileExtension;
            if (!move_uploaded_file($fileTmpPath, $venue_picture)) {
                echo "<script>alert('File upload failed.'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Only JPG and PNG files are allowed.'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Please select a valid file.'); window.history.back();</script>";
        exit();
    }

    // Insert into database
    $stmt = $pdo->prepare("
        INSERT INTO venue (venue_name, venue_picture) 
        VALUES (:venue_name, :venue_picture)
    ");
    $stmt->execute([
        ':venue_name' => $venue_name,
        ':venue_picture' => $venue_picture,
    ]);

    echo "<script>alert('Registration Successful'); window.location.href = 'registerVenue.blade.php';</script>";
}
?>
