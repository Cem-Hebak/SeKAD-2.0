<?php
session_start();
include('db_connection.php');
// Ensure the session variable for name is set
$full_name = $_SESSION['name'] ?? 'User'; // Fallback to 'User' if the name is not set
$first_name = explode(' ', $full_name)[0]; // Extract the first name
$role = htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8');


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
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>SeKAD</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-5 p-lg-0">
                <a href="index.blade.php" class="nav-item nav-link active">Home</a>
                <?php    if ($role === 'Staff' || $role === 'Admin'): ?>
                <a href="register.blade.php" class="nav-item nav-link">Register</a>
                <?php endif; ?>
                <!-- <a href="profile.blade.php" class="nav-item nav-link">Profile</a> -->
                <?php    if ($role === 'Student'): ?>
                <a href="counselStud.blade.php" class="nav-item nav-link">Counselling Session</a>
                <?php endif; ?>
                <?php    if ($role === 'Teacher' || $role === 'Staff'): ?>
                <a href="counselTeach.blade.php" class="nav-item nav-link">Counselling Session</a>
                <?php endif; ?>
                <?php    if ($role === 'Admin' || $role === 'Staff'): ?>
                <a href="AdminInsight.blade.php" class="nav-item nav-link">Admin Insight</a>
                <?php endif; ?>
                <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <?php    if ($role === 'Staff' || $role === 'Teacher' || $role === 'Admin'): ?>
                        <a href="Attendance Analytics.blade.php" class="dropdown-item">Attendance Analytics</a>
                        <a href="attendanceRecordFiltered.blade.php" class="dropdown-item">Attendance Record <br> Management</a>
                        <a href="announce.blade.php" class="dropdown-item">Maintenance Announcement <br> Form</a>
                        <a href="event.blade.php" class="dropdown-item">Event & Charity <br> Announcement Form</a>
                        <?php endif; ?>
                        <?php    if ($role === 'Student'): ?>
                        <a href="student_attendance.blade.php" class="dropdown-item">Attendance Record <br> Management</a>
                        <?php endif; ?>
                        <a href="attendance_rewards.blade.php" class="dropdown-item">Attendance Leaderboards</a>
                        <?php    if ($role === 'Staff' || $role === 'Admin'): ?>
                        <a href="Teacher Assign.blade.php" class="dropdown-item">Teacher Assign</a>
                        <a href="assign-student.blade.php" class="dropdown-item">Student Assign</a>
                        <?php endif; ?>
                        <a href="Facility_And_Equipment_Booking_Teacher.blade.php" class="dropdown-item">Venue Bookings</a>
                        
                        <a href="editProfile.blade.php" class="dropdown-item">Edit Profile</a>
                        <a href="setting.blade.php" class="dropdown-item">Settings</a>

                        <a href="login.blade.php" class="dropdown-item">Log out</a>
                    </div>
                </div>
                
            </div>
            <a href="profile.blade.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Hi, <?= htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8') ?><i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>

    <!-- Content -->
    <div class="container py-5">
        <h1 class="text-center mb-4">Filter Attendance</h1>

        <!-- Filter Form -->
        <form method="POST" action="attendanceRecordFiltered.blade.php" class="mb-4">
            <div class="row justify-content-center">
                <!-- Date Selection -->
                <div class="col-md-4">
                    <label for="date">Select Date:</label>
                    <input type="date" name="attendance_date" id="date" class="form-control" value="<?php echo $date; ?>" required>
                </div>
                <!-- Form Selection -->
                <div class="col-md-3">
                    <label for="form">Select Form:</label>
                    <select name="form" id="form" class="form-select">
                        <option value="">All Forms</option>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            $selected = ($form == "Form {$i}") ? 'selected' : '';
                            echo "<option value='{$i}' {$selected}>Form {$i}</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- Class Selection -->
                <div class="col-md-3">
                    <label for="class">Select Class:</label>
                    <select name="class" id="class" class="form-select">
                        <option value="">All Classes</option>
                        <!-- Class options will be populated dynamically -->
                    </select>
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
                } catch (PDOException $e) {
                    echo "<tr><td colspan='5' class='text-center'>Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5">
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
    </footer>

    <!-- Include Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formDropdown = document.getElementById('form');
            const classDropdown = document.getElementById('class');

            // Define classes for each form
            const classOptions = {
                '1': ['1 Cendekiawan', '1 Pendeta', '1 Sarjana', '1 Intelek'],
                '2': ['2 Cendekiawan', '2 Pendeta', '2 Sarjana', '2 Intelek'],
                '3': ['3 Cendekiawan', '3 Pendeta', '3 Sarjana', '3 Intelek'],
                '4': ['4 Cendekiawan', '4 Pendeta', '4 Sarjana', '4 Intelek'],
                '5': ['5 Cendekiawan', '5 Pendeta', '5 Sarjana', '5 Intelek'],
            };

            // Update class dropdown when form is selected
            formDropdown.addEventListener('change', function() {
                const selectedForm = formDropdown.value;
                classDropdown.innerHTML = '<option value="">All Classes</option>'; // Reset class dropdown

                if (selectedForm && classOptions[selectedForm]) {
                    classOptions[selectedForm].forEach(function(cls) {
                        const option = document.createElement('option');
                        option.value = cls;
                        option.textContent = cls;
                        classDropdown.appendChild(option);
                    });
                }
            });

            // Trigger change event to initialize dropdowns (if a form is already selected)
            formDropdown.dispatchEvent(new Event('change'));
        });
    </script>

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
