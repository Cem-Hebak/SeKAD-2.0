<?php
session_start();
include('db_connection.php');

// Handle date selection
$date = isset($_POST['attendance_date']) ? htmlspecialchars($_POST['attendance_date'], ENT_QUOTES, 'UTF-8') : date('Y-m-d');
$form = isset($_POST['form']) ? htmlspecialchars($_POST['form'], ENT_QUOTES, 'UTF-8') : '';
$class = isset($_POST['class']) ? htmlspecialchars($_POST['class'], ENT_QUOTES, 'UTF-8') : '';

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $student_id = intval($_POST['student_id']);
    $new_status = intval($_POST['new_status']);

    try {
        $stmt = $pdo->prepare("UPDATE attendance SET present = :new_status WHERE user_id = :student_id AND date = :attendance_date");
        $stmt->bindParam(':new_status', $new_status, PDO::PARAM_INT);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':attendance_date', $date, PDO::PARAM_STR);
        $stmt->execute();

        $success_message = "Attendance updated successfully.";
    } catch (PDOException $e) {
        $error_message = "Error updating attendance: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}

// Status Labels
$status_labels = [
    1 => "Present",
    2 => "Absent",
    3 => "Pending Submission Form",
    4 => "Absent With MC",
    5 => "Absent Because Family Matter",
    6 => "Absent Because Natural Disasters",
    7 => "Others",
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>eLEARNING - Attendance Filter</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
        <!-- Navbar Start -->
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

    <!-- Content -->
    <div class="container py-5">
        <h1 class="text-center mb-4">Filter Attendance</h1>

        <!-- Filter Form -->
        <form method="POST" action="attendanceRecordFiltered.blade.php" class="mb-4">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <label for="formSelect">Select Form:</label>
                    <select name="form" id="formSelect" class="form-control">
                        <option value="1" <?php echo ($form === '1') ? 'selected' : ''; ?>>Form 1</option>
                        <option value="2" <?php echo ($form === '2') ? 'selected' : ''; ?>>Form 2</option>
                        <option value="3" <?php echo ($form === '3') ? 'selected' : ''; ?>>Form 3</option>
                        <option value="4" <?php echo ($form === '4') ? 'selected' : ''; ?>>Form 4</option>
                        <option value="5" <?php echo ($form === '5') ? 'selected' : ''; ?>>Form 5</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="classSelect">Select Class:</label>
                    <select name="class" id="classSelect" class="form-control">
                        <option value="CENDEKIAWAN" <?php echo ($class === 'CENDEKIAWAN') ? 'selected' : ''; ?>>CENDEKIAWAN</option>
                        <option value="PENDETA" <?php echo ($class === 'PENDETA') ? 'selected' : ''; ?>>PENDETA</option>
                        <option value="SARJANA" <?php echo ($class === 'SARJANA') ? 'selected' : ''; ?>>SARJANA</option>
                        <option value="INTELEK" <?php echo ($class === 'INTELEK') ? 'selected' : ''; ?>>INTELEK</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="date">Select Date:</label>
                    <input type="date" name="attendance_date" id="date" class="form-control" value="<?php echo $date; ?>" required>
                </div>
                <div class="col-md-2 mt-4">
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
                    <th>Proof</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $query = "SELECT u.id as student_id, u.name, u.ic_number, a.present, a.proof
                              FROM users u
                              INNER JOIN attendance a
                              ON u.id = a.user_id
                              WHERE a.date = :attendance_date";

                    if (!empty($form)) {
                        $query .= " AND u.class LIKE :form_filter";
                    }
                    if (!empty($class)) {
                        $query .= " AND u.class LIKE :class_filter";
                    }

                    $query .= " ORDER BY u.name ASC";

                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':attendance_date', $date, PDO::PARAM_STR);
                    if (!empty($form)) {
                        $form_filter = $form . '%';
                        $stmt->bindParam(':form_filter', $form_filter, PDO::PARAM_STR);
                    }
                    if (!empty($class)) {
                        $class_filter = '%' . $class;
                        $stmt->bindParam(':class_filter', $class_filter, PDO::PARAM_STR);
                    }
                    $stmt->execute();
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($results)) {
                        foreach ($results as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . htmlspecialchars($row['ic_number'], ENT_QUOTES, 'UTF-8') . "</td>";

                            // Display attendance status
                            $status_label = isset($status_labels[$row['present']]) ? $status_labels[$row['present']] : "Unknown";
                            echo "<td>" . htmlspecialchars($status_label, ENT_QUOTES, 'UTF-8') . "</td>";

                            // Display proof
                            if (!empty($row['proof'])) {
                                echo "<td><a href='uploads/" . htmlspecialchars($row['proof'], ENT_QUOTES, 'UTF-8') . "' target='_blank'>View Proof</a></td>";
                            } else {
                                echo "<td>No Proof</td>";
                            }

                            // Dropdown for action
                            echo "<td>";
                            echo "<form method='POST'>
                                <input type='hidden' name='attendance_date' value='{$date}'>
                                <input type='hidden' name='student_id' value='{$row['student_id']}'>
                                <select name='new_status' class='form-select form-select-sm'>";
                            foreach ($status_labels as $status_id => $label) {
                                $selected = ($status_id == $row['present']) ? 'selected' : '';
                                echo "<option value='{$status_id}' {$selected}>{$label}</option>";
                            }
                            echo "</select>
                                <button type='submit' name='update_status' class='btn btn-primary btn-sm mt-2'>Update</button>
                            </form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No records found for the selected filters.</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='5' class='text-center'>Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
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
