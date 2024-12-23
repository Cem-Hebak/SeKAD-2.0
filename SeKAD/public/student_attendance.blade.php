<?php
session_start();
include('db_connection.php');

// Check if the user is logged in and is a student
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Student') {
//     header('Location: login.php');
//     exit();
// }

// $user_id = $_SESSION['user_id'];

// Handle date selection
$date = isset($_POST['attendance_date']) ? htmlspecialchars($_POST['attendance_date'], ENT_QUOTES, 'UTF-8') : date('Y-m-d');

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['proof_file'])) {
    $target_dir = "uploads/proofs/";
    $target_file = $target_dir . basename($_FILES["proof_file"]["name"]);
    $upload_ok = 1;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate file type
    $allowed_types = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
    if (!in_array($file_type, $allowed_types)) {
        $error_message = "Only JPG, JPEG, PNG, PDF, and DOCX files are allowed.";
        $upload_ok = 0;
    }

    if ($upload_ok && move_uploaded_file($_FILES["proof_file"]["tmp_name"], $target_file)) {
        try {
            $stmt = $pdo->prepare("UPDATE attendance SET proof = :proof WHERE user_id = :user_id AND date = :attendance_date");
            $stmt->bindParam(':proof', $target_file, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':attendance_date', $date, PDO::PARAM_STR);
            $stmt->execute();

            $success_message = "Proof uploaded successfully.";
        } catch (PDOException $e) {
            $error_message = "Error uploading proof: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    } else {
        $error_message = "Error uploading file.";
    }
}

// Fetch attendance records for the student
try {
    $stmt = $pdo->prepare("SELECT date, present, proof FROM attendance WHERE user_id = :user_id AND MONTH(date) = MONTH(CURDATE()) ORDER BY date DESC");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $attendance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error fetching attendance records: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Attendance</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h1 class="text-center">Your Attendance</h1>

    <!-- Filter Form -->
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <label for="attendance_date">Select Date:</label>
                <input type="date" name="attendance_date" class="form-control" value="<?php echo $date; ?>" required>
            </div>
            <div class="col-md-4">
                <label for="proof_file">Upload Proof:</label>
                <input type="file" name="proof_file" class="form-control" required>
            </div>
            <div class="col-md-2 mt-4">
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </form>

    <!-- Display Success/Error Messages -->
    <?php if (!empty($success_message)) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php } ?>
    <?php if (!empty($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

    <!-- Attendance Records -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Date</th>
            <th>Status</th>
            <th>Proof</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($attendance_records)) {
            foreach ($attendance_records as $record) {
                $status = isset($status_labels[$record['present']]) ? $status_labels[$record['present']] : "Unknown";
                echo "<tr>";
                echo "<td>" . htmlspecialchars($record['date'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>";
                if (!empty($record['proof'])) {
                    echo "<a href='" . htmlspecialchars($record['proof'], ENT_QUOTES, 'UTF-8') . "' target='_blank'>View Proof</a>";
                } else {
                    echo "No Proof";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3' class='text-center'>No records found for this month.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
