<?php
session_start();
include('db_connection.php');

// Handle date selection
$date = isset($_POST['attendance_date']) ? htmlspecialchars($_POST['attendance_date'], ENT_QUOTES, 'UTF-8') : date('Y-m-d');

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $student_id = intval($_POST['student_id']);
    $new_status = intval($_POST['new_status']);

    try {
        $stmt = $pdo->prepare("
            UPDATE attendance
            SET present = :new_status
            WHERE user_id = :student_id AND date = :attendance_date
        ");
        $stmt->bindParam(':new_status', $new_status, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':attendance_date', $date, PDO::PARAM_STR);
        $stmt->execute();

        $success_message = "Attendance updated successfully.";
    } catch (PDOException $e) {
        $error_message = "Error updating attendance: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>eLEARNING - eLearning HTML Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">



        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/font-size.css" rel="stylesheet">

        <link id="light-mode" rel="stylesheet" href="{{ asset('css/light.css') }}">
        <link id="dark-mode" rel="stylesheet" href="{{ asset('css/dark.css') }}" disabled>
    </head>

<body>
    <!-- Navbar -->
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

                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-5">
        <h1 class="text-center mb-4">Filter Attendance by Date</h1>

        <!-- Date Filter -->
        <form method="POST" action="attendanceRecordFiltered.blade.php" class="mb-4">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <input type="date" name="attendance_date" class="form-control" value="<?php echo $date; ?>" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
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

        <!-- Attendance Table -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>IC Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
try {
    // Query to fetch students with present values 2 (Absent) or 3 (Pending)
    $stmt = $pdo->prepare("
        SELECT u.id as student_id, u.name, u.ic_number, a.present
        FROM users u
        INNER JOIN attendance a ON u.id = a.user_id
        WHERE a.date = :attendance_date AND a.present IN (2, 3)
        ORDER BY u.name ASC
    ");
    $stmt->bindParam(':attendance_date', $date, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['ic_number'], ENT_QUOTES, 'UTF-8') . "</td>";

            // Display attendance status
            $status_label = ($row['present'] == 2) ? "Absent" : "Pending";
            echo "<td>" . htmlspecialchars($status_label, ENT_QUOTES, 'UTF-8') . "</td>";

            // Action buttons for Pending students
            if ($row['present'] == 3) {
                echo "<td>
                    <form method='POST' class='d-inline'>
                        <input type='hidden' name='attendance_date' value='{$date}'>
                        <input type='hidden' name='student_id' value='{$row['student_id']}'>
                        <input type='hidden' name='new_status' value='2'>
                        <button type='submit' name='update_status' class='btn btn-danger btn-sm'>Set Absent</button>
                    </form>
                    <form method='POST' class='d-inline'>
                        <input type='hidden' name='attendance_date' value='{$date}'>
                        <input type='hidden' name='student_id' value='{$row['student_id']}'>
                        <input type='hidden' name='new_status' value='4'>
                        <button type='submit' name='update_status' class='btn btn-success btn-sm'>Set Excused</button>
                    </form>
                </td>";
            } else {
                echo "<td></td>";
            }
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4' class='text-center'>No records found for the selected date.</td></tr>";
    }
} catch (PDOException $e) {
    echo "<tr><td colspan='4' class='text-center'>Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
}
?>

            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5">
        <p>&copy; 2024 Your Website. All Rights Reserved.</p>
    </footer>

    <!-- Include Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
