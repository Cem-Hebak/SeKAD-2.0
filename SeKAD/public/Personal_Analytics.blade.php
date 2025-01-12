<?php
session_start();
include('db_connection.php');

// Ensure the student is logged in
// if (!isset($_SESSION['student_id'])) {
//     header("Location: login.blade.php");
//     exit;
// }

// Get the logged-in student's details
$ic_number = htmlspecialchars($_SESSION['ic_number'], ENT_QUOTES, 'UTF-8');
$name = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8');

$filter_month = isset($_GET['filter_month']) ? $_GET['filter_month'] : null;

// Fetch attendance data grouped by status
try {
    $query = "
        SELECT
            present,
            COUNT(*) AS count
        FROM attendance a
        INNER JOIN users u ON a.user_id = u.id
        WHERE u.ic_number = :ic_number
    ";

    if ($filter_month) {
        $query .= " AND DATE_FORMAT(a.date, '%Y-%m') = :filter_month";
    }

    $query .= " GROUP BY present ORDER BY present ASC";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':ic_number', $ic_number, PDO::PARAM_STR);

    if ($filter_month) {
        $stmt->bindParam(':filter_month', $filter_month, PDO::PARAM_STR);
    }

    $stmt->execute();
    $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching attendance data: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}

// Map status codes to labels
$status_labels = [
    1 => "Present",
    2 => "Absent",
    3 => "Pending Submission Form",
    4 => "Absent With MC",
    5 => "Absent Because Family Matter",
    6 => "Absent Because Natural Disasters",
    7 => "Others"
];

$labels = [];
$data = [];

foreach ($attendance_data as $row) {
    $labels[] = $status_labels[$row['present']];
    $data[] = $row['count'];
}
try {
    $query = "
        SELECT
            a.date,
            a.present
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
    $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching attendance data: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Attendance Analytics</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
                        <a href="attendanceRecordFiltered.blade.php" class="dropdown-item">Attendance Record Management</a>
                        <a href="announce.blade.php" class="dropdown-item">Maintenance Announcement Form</a>
                        <a href="event.blade.php" class="dropdown-item">Event & Cahrity Announcement Form</a>
                        <?php endif; ?>
                        <?php    if ($role === 'Student'): ?>
                        <a href="student_attendance.blade.php" class="dropdown-item">Attendance Record Management</a>
                        <?php endif; ?>
                        <a href="attendance_rewards.blade.php" class="dropdown-item">Attendance Leaderboards</a>
                        <?php    if ($role === 'Staff' || $role === 'Admin'): ?>
                        <a href="Teacher Assign.blade.php" class="dropdown-item">Teacher Assign</a>
                        <a href="assign-students.blade.php" class="dropdown-item">Student Assign</a>
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
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">
                    Hi, <?php echo $name; ?>

                </h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    </div>
    <div class="container mt-5">
        <h2>Personal Analytics By Month</h2>
        <style>
            /* Ensure all table columns have the same width */
            .table th, .table td {
                 /* Center align the text and buttons */
                vertical-align: middle; /* Center align content vertically */
                width: 20%; /* Set equal width for all columns */
            }

            /* Add some spacing and styling for the table */
            .table {
                table-layout: fixed; /* Ensures consistent column width */
                width: 100%;
            }
        </style>
        <table class="table table-striped table-bordered">

        <tr>
            <td colspan="2">
                <form method="GET" class="mb-4">
                    <label for="month" class="form-label">Filter by Month:</label>
                    <input type="month" id="month" name="filter_month" class="form-control"
                        value="<?php echo isset($_GET['filter_month']) ? htmlspecialchars($_GET['filter_month'], ENT_QUOTES, 'UTF-8') : ''; ?>">

                    <form method="GET" class="mb-4">
                        <label for="status_filter" class="form-label mt-3">Filter by Status:</label>
                        <select id="status_filter" name="status_filter" class="form-select">
                            <option value="both" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] === 'both') ? 'selected' : ''; ?>>Both</option>
                            <option value="present" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] === 'present') ? 'selected' : ''; ?>>Present Only</option>
                            <option value="absent" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] === 'absent') ? 'selected' : ''; ?>>Absent Only</option>
                        </select>

                        <button type="submit" class="btn btn-primary mt-2">Filter</button>
                    </form>
            </td>
        </tr>
        <tr>
            <td>



                <?php
                // Apply status filter
                $status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'both';
                $status_condition = '';

                if ($status_filter === 'present') {
                    $status_condition = " AND a.present = 1";
                } elseif ($status_filter === 'absent') {
                    $status_condition = " AND a.present != 1";
                }

                // Update query to include status filter
                $query = "
                    SELECT
                        a.date,
                        a.present
                    FROM attendance a
                    INNER JOIN users u ON a.user_id = u.id
                    WHERE u.ic_number = :ic_number
                ";

                if ($filter_month) {
                    $query .= " AND DATE_FORMAT(a.date, '%Y-%m') = :filter_month";
                }

                $query .= $status_condition;
                $query .= " ORDER BY a.date ASC";

                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':ic_number', $ic_number, PDO::PARAM_STR);

                if ($filter_month) {
                    $stmt->bindParam(':filter_month', $filter_month, PDO::PARAM_STR);
                }

                $stmt->execute();
                $attendance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <?php if ($filter_month): ?>
                    <div class="container mt-4">
                        <h3>Attendance Details for <?php echo htmlspecialchars($filter_month, ENT_QUOTES, 'UTF-8'); ?></h3>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($attendance_data)): ?>
                                    <?php foreach ($attendance_data as $row): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo htmlspecialchars($status_labels[$row['present']], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2">No attendance data found for the selected filters.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </td>
            <td>
                <div class="chart-container" style="position: center; height:75vh; width:100%; padding: 10%;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </td>

        </tr>
    </table>
    </div>



    <!-- Footer Start -->
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
    <!-- Footer End -->

    <script>
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                data: <?php echo json_encode($data); ?>,
                backgroundColor: [
                    '#4CAF50', '#F44336', '#FF9800', '#03A9F4', '#9C27B0', '#FFC107', '#8BC34A'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const count = tooltipItem.raw;
                            const total = <?php echo array_sum($data); ?>;
                            const percentage = ((count / total) * 100).toFixed(2);
                            return `${tooltipItem.label}: ${count} (${percentage}%)`;
                        }
                    }
                }
            }
        }
        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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
