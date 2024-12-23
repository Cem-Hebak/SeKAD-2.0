<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user ID and the selected class from the POST request
    $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $selectedClass = isset($_POST['class']) ? trim($_POST['class']) : '';

    if ($userId > 0 && !empty($selectedClass)) {
        // Update the class in the database
        $stmt = $conn->prepare("UPDATE users SET class = ? WHERE id = ?");
        $stmt->bind_param("si", $selectedClass, $userId);

        if ($stmt->execute()) {
            // Redirect back to the main page with a success message
            header("Location: assign-student.blade.php?status=success");
        } else {
            // Redirect back to the main page with an error message
            header("Location: assign-student.blade.php?status=error");
        }

        $stmt->close();
    } else {
        // Redirect back to the main page with an invalid input error
        header("Location: assign-student.blade.php?status=invalid_input");
    }
}

$conn->close();
?>
<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'success'): ?>
        <p style="color: green;">Class assigned successfully!</p>
    <?php elseif ($_GET['status'] === 'error'): ?>
        <p style="color: red;">An error occurred while assigning the class.</p>
    <?php elseif ($_GET['status'] === 'invalid_input'): ?>
        <p style="color: orange;">Invalid input provided. Please try again.</p>
    <?php endif; ?>
<?php endif; ?>
