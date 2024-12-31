<?php
include('db_connection.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venue_id = intval($_POST['venue_id']);
    
    // Delete the venue from the database
    $stmt = $pdo->prepare("DELETE FROM venue WHERE id = :id");
    $stmt->execute([':id' => $venue_id]);
    
    echo "<script>alert('Venue removed successfully.'); window.location.href = 'DeleteVenue.blade.php';</script>";
    exit();
}
?>
