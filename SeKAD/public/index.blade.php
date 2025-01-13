
<?php
    session_start();
    include('db_connection.php');

    // Ensure the user is logged in
    if (!isset($_SESSION['ic_number']) || !isset($_SESSION['role'])) {
        header("Location: login.php");
        exit;
    }

    // Get the logged-in student's details
    $ic_number = htmlspecialchars($_SESSION['ic_number'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8');
    $mobilenumber = htmlspecialchars($_SESSION['mobilenumber'], ENT_QUOTES, 'UTF-8');
    $role = htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8');
    $nationality = htmlspecialchars($_SESSION['nationality'], ENT_QUOTES, 'UTF-8');

    // Optional fields with fallback values
    $emergencymobilenumber = htmlspecialchars($_SESSION['emergencymobilenumber'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $class = htmlspecialchars($_SESSION['class'] ?? 'Not Assigned', ENT_QUOTES, 'UTF-8');
    $date_of_birth = htmlspecialchars($_SESSION['date_of_birth'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $gender = htmlspecialchars($_SESSION['gender'] ?? 'Not Specified', ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($_SESSION['address'] ?? 'Not Available', ENT_QUOTES, 'UTF-8');
    $fname = htmlspecialchars($_SESSION['fname'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $fcontact = htmlspecialchars($_SESSION['fcontact'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $foccupation = htmlspecialchars($_SESSION['foccupation'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $mname = htmlspecialchars($_SESSION['mname'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $mcontact = htmlspecialchars($_SESSION['mcontact'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $moccupation = htmlspecialchars($_SESSION['moccupation'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $gname = htmlspecialchars($_SESSION['gname'] ?? 'Not Applicable', ENT_QUOTES, 'UTF-8');
    $gcontact = htmlspecialchars($_SESSION['gcontact'] ?? 'Not Applicable', ENT_QUOTES, 'UTF-8');
    $goccupation = htmlspecialchars($_SESSION['goccupation'] ?? 'Not Applicable', ENT_QUOTES, 'UTF-8');
    $blood_type = htmlspecialchars($_SESSION['blood_type'] ?? 'Unknown', ENT_QUOTES, 'UTF-8');
    $allergies = htmlspecialchars($_SESSION['allergies'] ?? 'None', ENT_QUOTES, 'UTF-8');

    // Attendance filtering options
    $filter_month = isset($_GET['filter_month']) ? $_GET['filter_month'] : null;

    // Fetch attendance data grouped by status
    try {

        // Get logged-in student's IC number
        $loggedInICNumber = $_SESSION['ic_number'];
        $loggedInRole = $_SESSION['role'];

        $query = "
            SELECT present, COUNT(*) AS count
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

    // Calculate attendance percentage for the student
    $presentValues = [1, 4]; // Present and Absent With MC are considered as present
    $attendanceThreshold = 75;

    $lowAttendanceAlert = false; // Default: no alert

    try {
        // Query to calculate attendance percentage
        if($loggedInRole === 'Student'){
            $query = "SELECT
                        COUNT(CASE WHEN present IN (" . implode(',', $presentValues) . ") THEN 1 END) AS total_attendances,
                        COUNT(*) AS total_records
                    FROM attendance
                    WHERE ic_number = :ic_number";

            $stmt = $pdo->prepare($query);
            $stmt->execute(['ic_number' => $ic_number]);
            $result = $stmt->fetch();

            $totalAttendances = $result['total_attendances'] ?? 0;
            $totalRecords = $result['total_records'] ?? 0;
            $attendancePercentage = ($totalRecords > 0) ? ($totalAttendances / $totalRecords) * 100 : 0;

            // Check if attendance is below the threshold
            $lowAttendanceAlert = "";
            if ($attendancePercentage < $attendanceThreshold) {
                $lowAttendanceAlert = true; // Trigger low attendance alert
            }
        }
    } catch (PDOException $e) {
        die("Error calculating attendance percentage: " . $e->getMessage());
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
    try {
        $query = "SELECT id, name AS Title, description AS Description, date_of_reporting AS start, date_of_repair_completion AS end, picture AS pic FROM maintenance_reports ORDER BY created_at DESC LIMIT 2";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching announcements: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
    }
    try {
        $query = "SELECT id, event_name AS Title, description AS Description, start_date AS startdate, finish_date AS finishdate, start_time AS start, finish_time AS end, poster_path AS pic FROM events ORDER BY created_at DESC LIMIT 2";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $eventann = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching announcements: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
    }
    // Ensure the session variable for name is set
    $full_name = $_SESSION['name'] ?? 'User'; // Fallback to 'User' if the name is not set
    $first_name = explode(' ', $full_name)[0]; // Extract the first name
?>


<!DOCTYPE html>
<html lang="en">
<!-- "include('db_connection.php')" ni untuk import database -->
<head>
    <meta charset="utf-8">
    <title>eLEARNING - eLearning HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Low Attendance css -->
    <link href="css/lowAttend.css" rel="stylesheet">

    <!-- Pop-up notification for low attendance -->
    <?php if ($lowAttendanceAlert): ?>
        <div id="attendanceAlert" onclick="window.location.href='low-attendance.php';">
            <strong>Alert:</strong> Your attendance is below the minimum requirement!
            <a href="low-attendance.php">Click here to view details.</a>
        </div>
    <?php endif; ?>

    <script>
        // JavaScript to show the pop-up notification
        window.onload = function() {
            var alertBox = document.getElementById('attendanceAlert');
            if (alertBox) {
                alertBox.style.display = 'block';
            }
        };
    </script>


    <!-- Low Attendance Alert
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/low-attendance') // Call Laravel route
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const alertBox = document.createElement('div');
                        alertBox.innerHTML = `
                            <div class="alert alert-warning">
                                <strong>Low Attendance Alert!</strong> Some students have attendance below 75%.
                                <a href="/attendance/warning" class="btn btn-primary">See More</a>
                            </div>
                        `;
                        document.body.prepend(alertBox); // Add alert to the top of the page
                    }
                })
                .catch(error => console.error('Error fetching attendance data:', error));
        });
    </script> -->

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

    <link href="css/style.css" rel="stylesheet">

    <link href="css/font-size.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


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
    <!-- Navbar End -->


    <!-- Carousel Start -->
     
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <?php foreach ($announcements as $announcement): ?>
                <div class="owl-carousel-item position-relative">
                <img class="img-fluid" 
                            src="<?= htmlspecialchars($announcement['pic']) ?>" 
                            alt="Announcement Image" 
                            onerror="this.onerror=null; this.src='Sekolah.png';" 
                            style="width: 1366px; height: 768px; object-fit: cover; max-width: 100%; max-height: 100%; display: block;">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-sm-10 col-lg-8">
                                    <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Facility Maintenance Announcement</h5>
                                    <h1 class="display-3 text-white animated slideInDown">Maintenance</h1>
                                    <p class="fs-5 text-white mb-4 pb-2"><?= htmlspecialchars($announcement['Description']) ?></p>
                                    <h1 class="display-3 text-white animated slideInDown"><?= htmlspecialchars($announcement['start']) ?>   To   <?= htmlspecialchars($announcement['end']) ?></h1>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php foreach ($eventann as $eventanns): ?>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src=<?= htmlspecialchars($eventanns['pic']) ?> alt="Announcement Image">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-sm-10 col-lg-8">
                                    <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Event And Charity Announcement</h5>
                                    <h1 class="display-3 text-white animated slideInDown"><?= htmlspecialchars($eventanns['Title']) ?></h1>
                                    <p class="fs-5 text-white mb-4 pb-2"><?= htmlspecialchars($eventanns['Description']) ?></p>
                                    <h1 class="display-3 text-white animated slideInDown"><?= htmlspecialchars($eventanns['startdate']) ?>   Until   <?= htmlspecialchars($eventanns['finishdate']) ?></h1>
                                    <h1 class="display-3 text-white animated slideInDown"><?= htmlspecialchars($eventanns['start']) ?>   To   <?= htmlspecialchars($eventanns['end']) ?></h1>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
     
    <!-- <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Announcement</h5>
                                <h1 class="display-3 text-white animated slideInDown">News Title #1</h1>
                                <p class="fs-5 text-white mb-4 pb-2">News Description</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Announcement</h5>
                                <h1 class="display-3 text-white animated slideInDown">News Title #2</h1>
                                <p class="fs-5 text-white mb-4 pb-2">News Description</p>
                                <a href="" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Carousel End -->

    <!-- <a href="https://www.google.com" target="_blank"> Link to the first page -->
    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <a href="profile.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Profile</h5>
                            <p>View or Edit your credentials here !</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php    if ($role === 'Teacher' || $role === 'Staff'): ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="counselTeach.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                            <h5 class="mb-3">Counselling Sessions</h5>
                            <p>Approve or Decline Student counselling appointment</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php    if ($role === 'Student'): ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="counselStud.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                            <h5 class="mb-3">Counselling Sessions</h5>
                            <p>Set an appointment with School Counsellor to talk about anything !</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                
                <?php    if ($role === 'Staff' || $role === 'Admin'): ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="assign-student.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Student Class Management</h5>
                            <p>Assign a student class here!</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php    if ($role === 'Staff'|| $role === 'Admin'): ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="Teacher Assign.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-chalkboard text-primary mb-4"></i>
                            <h5 class="mb-3">Teacher Class Management</h5>
                            <p>Assign a teachers class here</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="Facility_And_Equipment_Booking_Teacher.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-clipboard text-primary mb-4"></i>
                            <h5 class="mb-3">Facility & Equipment Booking</h5>
                            <p>Book or Check any Facility and Equipment here !</p>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="attendance_rewards.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-medal text-primary mb-4"></i>
                            <h5 class="mb-3">Attendance Leaderboard</h5>
                            <p>Check School Student attendance rankings here!</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php    if ($role === 'Teacher' || $role === 'Staff'|| $role === 'Admin'): ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="Attendance Analytics.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-chart-bar text-primary mb-4"></i>
                            <h5 class="mb-3">Attendance Analytics</h5>
                            <p>Check School Student Attendance Analytics here!</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php    if ($role === 'Teacher' || $role === 'Staff'): ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="attendanceRecordFiltered.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-list text-primary mb-4"></i>
                            <h5 class="mb-3">Attendance Record Management</h5>
                            <p>Approve Or Decline Student Medical Certificate / Other Reason for student absence</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php    if ($role === 'Student'): ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="student_attendance.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-list text-primary mb-4"></i>
                            <h5 class="mb-3">Attendance Record Management</h5>
                            <p>Upload your Medical Certificate or Other Certificate for your absence</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php    if ($role === 'Staff' || $role === 'Teacher'): ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="announce.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-school text-primary mb-4"></i>
                            <h5 class="mb-3">Facility Maintenance Announcement Form</h5>
                            <p>Create a new Announcement for Facility Maintenance</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <?php    if ($role === 'Staff' || $role === 'Teacher'): ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="event.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-hand-holding-heart text-primary mb-4"></i>
                            <h5 class="mb-3">Event & Charity Announcement Form</h5>
                            <p>Create a new Announcement for any new Event or Charity here!</p>
                        </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <a href="setting.blade.php" target="_blank">
                        <div class="p-4">
                            <i class="fa fa-3x fa-cog text-primary mb-4"></i>
                            <h5 class="mb-3">Settings</h5>
                            <p>Website settings</p>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Attendance chart -->
    <?php    if ($role === 'Student'): ?>
    <!-- Personal Attendance Chart Start -->
        <div class="container mt-5">
            <h2>Personal Analytics</h2>
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
                        <style>
                            .table-container {
                                max-height: 350px; /* Total height of the scrollable area */
                                overflow-y: auto; /* Enable vertical scrolling */
                            }

                            .table {
                                table-layout: fixed; /* Ensures consistent column widths */
                                width: 100%;
                                border-collapse: collapse;
                            }

                            .table th,
                            .table td {
                                text-align: center;
                                box-sizing: border-box; /* Includes padding and borders in width calculation */
                            }

                            .table thead th {
                                position: sticky;
                                top: 0;
                                background-color: #f8f9fa; /* Matches header background */
                                z-index: 1; /* Keeps the header above the scrolling content */
                            }
                        </style>

                        <h3>Attendance Details for <?php echo htmlspecialchars($filter_month, ENT_QUOTES, 'UTF-8'); ?></h3>
                        <div class="table-container">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">Date</th>
                                        <th style="width: 50%;">Status</th>
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

    <!-- Personal Attendance Chart End -->
    <?php endif; ?>

    <!-- Personal Attendance Chart End -->





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


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="assets/global.js"></script>

    <!-- Personal Attendance Javascript -->
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
</body>

</html>
