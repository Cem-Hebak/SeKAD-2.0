<?php
session_start();
include('db_connection.php');

// Ensure the student is logged in
// if (!isset($_SESSION['student_id'])) {
//     header("Location: login.blade.php");
//     exit;
// }

// Get the logged-in student's ID
$ic_number = htmlspecialchars($_SESSION['ic_number'], ENT_QUOTES, 'UTF-8');
$name = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8');

// Handle file uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['proof_file'])) {
    $attendance_date = htmlspecialchars($_POST['attendance_date'], ENT_QUOTES, 'UTF-8');
    $target_dir = "uploads/proofs/";
    $file_name = basename($_FILES['proof_file']['name']);
    $target_file = $target_dir . time() . "_" . $file_name; // Add a timestamp for uniqueness

    if (move_uploaded_file($_FILES['proof_file']['tmp_name'], $target_file)) {
        // Update proof column in the database
        try {
            $stmt = $pdo->prepare("
                UPDATE attendance
                SET proof = :proof
                WHERE user_id = (SELECT id FROM users WHERE ic_number = :ic_number)
                AND date = :attendance_date
            ");
            $stmt->bindParam(':proof', $target_file, PDO::PARAM_STR);
            $stmt->bindParam(':ic_number', $ic_number, PDO::PARAM_STR);
            $stmt->bindParam(':attendance_date', $attendance_date, PDO::PARAM_STR);
            $stmt->execute();

            $success_message = "File uploaded successfully!";
        } catch (PDOException $e) {
            $error_message = "Error uploading file: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    } else {
        $error_message = "Error moving uploaded file.";
    }
}

// Fetch attendance records for the student
try {
    $stmt = $pdo->prepare("
        SELECT a.date, a.proof
        FROM attendance a
        INNER JOIN users u ON a.user_id = u.id
        WHERE u.ic_number = :ic_number
        ORDER BY a.date ASC
    ");
    $stmt->bindParam(':ic_number', $ic_number, PDO::PARAM_STR);
    $stmt->execute();
    $attendance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching attendance records: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}

$filter_month = isset($_GET['filter_month']) ? $_GET['filter_month'] : null;

try {
    $query = "
        SELECT a.date, a.proof
        FROM attendance a
        INNER JOIN users u ON a.user_id = u.id
        WHERE u.ic_number = :ic_number
    ";

    if ($filter_month) {
        $query .= " AND DATE_FORMAT(a.date, '%Y-%m') = :filter_month";
    }

    $query .= " ORDER BY a.date ASC";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ic_number', $ic_number, PDO::PARAM_STR);

    if ($filter_month) {
        $stmt->bindParam(':filter_month', $filter_month, PDO::PARAM_STR);
    }

    $stmt->execute();
    $attendance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching attendance records: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>eLEARNING - Student Upload</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>eLEARNING</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.blade.php" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="courses.html" class="nav-item nav-link">Courses</a>
                <a href="attendanceRecord1.blade.php" class="nav-item nav-link">Attendance Record</a>
                <a href="attendanceRecordFiltered.blade.php" class="nav-item nav-link active">Filtered Attendance</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="Teacher Assign.blade.php" class="dropdown-item">Teacher Assign</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                        <a href="profile.blade.php" class="dropdown-item">Profile</a>
                        <a href="setting.blade.php" class="dropdown-item">Setting</a>
                        <a href="announce.blade.php" class="dropdown-item">Announcement</a>
                        <a href="login.blade.php" class="dropdown-item">Log In</a>
                        <a href="logout.blade.php" class="dropdown-item">Log Out</a>
                        <a href="register.blade.php" class="dropdown-item">Register</a>
                        <a href="attendanceRecordFiltered.blade.php" class="dropdown-item">Filtered Attendance</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">
                        Hi, <?php echo $name; ?>
                    </h1>
                    <h1 class="text-center mb-4">Upload Attendance Proof</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <form method="GET" class="mb-4">
            <label for="month" class="form-label">Filter by Month:</label>
            <input type="month" id="month" name="filter_month" class="form-control"
                   value="<?php echo isset($_GET['filter_month']) ? htmlspecialchars($_GET['filter_month'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            <button type="submit" class="btn btn-primary mt-2">Filter</button>
        </form>

    <!-- Success/Error Messages -->
    <?php if (!empty($success_message)) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php } ?>
    <?php if (!empty($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>


    <!-- Attendance Records -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
            <th>Date</th>
            <th>Proof</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($attendance_records)) { ?>
            <?php foreach ($attendance_records as $record) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['date'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <?php if (!empty($record['proof'])) { ?>
                            <a href="<?php echo htmlspecialchars($record['proof'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">View Proof</a>
                        <?php } else { ?>
                            No Proof Uploaded
                        <?php } ?>
                    </td>
                    <td>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="attendance_date" value="<?php echo htmlspecialchars($record['date'], ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="file" name="proof_file" accept=".jpg,.jpeg,.png,.pdf" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
                <td colspan="3" class="text-center">No attendance records found.</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en', // Default language of your website
            includedLanguages: 'en,ms', // Languages to include (English and Bahasa Melayu)
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>
