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
    <form method="GET" action="">
        <div class="row mb-3">
            <!-- Form Dropdown -->
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

            <!-- Class Dropdown -->
            <div class="col-md-4">
                <label for="classSelect">Select Class:</label>
                <select name="class" id="classSelect" class="form-control">
                    <option value="Cendekiawan" <?php echo ($class === 'Cendekiawan') ? 'selected' : ''; ?>>Cendekiawan</option>
                    <option value="Pendeta" <?php echo ($class === 'Pendeta') ? 'selected' : ''; ?>>Pendeta</option>
                    <option value="Sarjana" <?php echo ($class === 'Sarjana') ? 'selected' : ''; ?>>Sarjana</option>
                    <option value="Intelek" <?php echo ($class === 'Intelek') ? 'selected' : ''; ?>>Intelek</option>
                </select>
            </div>

            <!-- Date Picker -->
            <div class="col-md-4">
                <label for="dateSelect">Select Date:</label>
                <input type="date" name="date" id="dateSelect" class="form-control"
                       value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Filter</button>
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
// Check if the filters are set
if (!empty($form) && !empty($class)) {
    $targetName = $form . " " . $class;

    try {
        // Updated query
        $sql = "SELECT b.id AS student_id, b.name, b.class, u.ic_number, a.present, a.proof
                FROM attendance b
                JOIN users u ON b.id = u.id
                LEFT JOIN attendance a ON b.id = a.user_id AND a.date = :attendance_date
                WHERE b.class = :target_class AND u.role = 'Student'";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':attendance_date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':target_class', $targetName, PDO::PARAM_STR);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<tr><td colspan='5' class='text-center'>Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
    }
}
?>
<?php
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
            echo "<td><a href='" . htmlspecialchars($row['proof'], ENT_QUOTES, 'UTF-8') . "' target='_blank'>View Proof</a></td>";
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
?>

            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5 justify-content-center text-center">
            <!-- Quick Links -->
            
            <!-- Contact Information -->
            <div class="">
                <h4 class="text-white mb-4">Contact</h4>
                <p class="mb-2">
                    <i class="fa fa-map-marker-alt me-3"></i>
                    Sekolah Menengah Sains Labuan, <br>
                    Jalan Sungai Pagar 87032, <br> Wilayah Persekutuan Labuan
                </p>
                <p class="mb-2">
                    <i class="fa fa-phone-alt me-3"></i>
                    (+60) 87 461525 (Office),<br>
                      (+60) 87 462835 (Fax)
                </p>
                <div class="d-flex justify-content-center pt-2">
                    <a class="btn btn-outline-light btn-social me-2" href="https://www.facebook.com/share/1Ar5pkmhEn/?mibextid=wwXIfr">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright d-flex flex-column align-items-center">
            <div class="text-center mb-3">
                &copy; <a class="text-light border-bottom" href="index.blade.php">SeKAD</a>, All Rights Reserved.
            </div>
            
        </div>
    </div>
</div>

    <!-- Include Scripts -->
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
