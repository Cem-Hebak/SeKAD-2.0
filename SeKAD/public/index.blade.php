
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
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.blade.php" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="login.blade.php" class="nav-item nav-link">Log In</a>
                <a href="register.blade.php" class="nav-item nav-link">Register</a>
                <a href="profile.blade.php" class="nav-item nav-link">Profile</a>
                <a href="counselStud.blade.php" class="nav-item nav-link">Counselling Session</a>
                <a href="AdminInsight.blade.php" class="nav-item nav-link">Admin Insight</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="Attendance Analytics.blade.php" class="dropdown-item">Attendance Analytics</a>
                        <a href="Teacher Assign.blade.php" class="dropdown-item">Teacher Assign</a>
                        <a href="Facility_And_Equipment_Booking_Teacher.blade.php" class="dropdown-item">Venue Booking</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                        <a href="login.php" class="dropdown-item">Log In</a>
                        <a href="register.php" class="dropdown-item">Register</a>
                        <a href="showCalendar.php" class="dropdown-item">Calendar</a>
                        <a href="editProfile.blade.php" class="dropdown-item">Edit Profile</a>
                        <a href="Facility_And_Equipment_Booking_Student.php" class="dropdown-item">Venue Student</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->
     
    <!-- <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <?php foreach ($announcements as $announcement): ?>
                <div class="owl-carousel-item position-relative">
                    <img class="img-fluid" src="img/carousel-placeholder.jpg" alt="Announcement Image">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-sm-10 col-lg-8">
                                    <h5 class="text-primary text-uppercase mb-3 animated slideInDown">Announcement</h5>
                                    <h1 class="display-3 text-white animated slideInDown"><?= htmlspecialchars($announcement['Title']) ?></h1>
                                    <p class="fs-5 text-white mb-4 pb-2"><?= htmlspecialchars($announcement['Description']) ?></p>
                                    <a href="#" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div> from database nanti
     -->
    <div class="container-fluid p-0 mb-5">
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
    </div>
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
                <?php    if ($role === 'Teacher'): ?>
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
                
                
                <?php    if ($role === 'Staff'): ?>
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
                <?php    if ($role === 'Staff'): ?>
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
                <?php    if ($role === 'Teacher' || $role === 'Staff'): ?>
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
                        <a href="https://www.google.com" target="_blank">
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
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Compact Attendance Chart</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            .chart-container {
                width: 40%;
                margin: 30px auto;
            }
            .chart-summary {
                text-align: center;
                margin-top: 10px;
                font-size: 1em;
            }
        </style>
    </head>
    <body>
        <div class="chart-container">
            <canvas id="attendanceChart"></canvas>
            <div class="chart-summary" id="chartSummary"></div>
        </div>
    
        <script>
            // Dummy attendance data
            const data = {
                attend: 85,
                total_days: 100
            };
    
            // Calculate absences
            const absence = data.total_days - data.attend;
    
            // Render the chart
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            const attendanceChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Attendance', 'Absence'],
                    datasets: [{
                        label: 'Attendance',
                        data: [data.attend, absence],
                        backgroundColor: ['#4CAF50', '#FF5252'],
                        borderColor: ['#4CAF50', '#FF5252'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const total = data.attend + absence;
                                    const value = tooltipItem.raw;
                                    const percentage = ((value / total) * 100).toFixed(2);
                                    return `${tooltipItem.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
    
            // Display summary
            document.getElementById('chartSummary').innerText = `Attendance: ${data.attend} / ${data.total_days}`;
        </script>
    </body>
    <!-- Dummy -->
    
    <!-- <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Attendance Chart</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            .chart-container {
                width: 40%;
                margin: 30px auto;
            }
            .chart-summary {
                text-align: center;
                margin-top: 10px;
                font-size: 1em;
            }
        </style>
    </head>
    <body>
        <div class="chart-container">
            <canvas id="attendanceChart"></canvas>
            <div class="chart-summary" id="chartSummary"></div>
        </div>
    
        <script>
            // Fetch attendance data
            fetch('attendance.php') // Replace with the correct PHP file path
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('attendanceChart').getContext('2d');
                    const attendanceChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Attendance', 'Absence'],
                            datasets: [{
                                label: 'Attendance',
                                data: [data.attend, data.absence],
                                backgroundColor: ['#4CAF50', '#FF5252'],
                                borderColor: ['#4CAF50', '#FF5252'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            const total = data.attend + data.absence;
                                            const value = tooltipItem.raw;
                                            const percentage = ((value / total) * 100).toFixed(2);
                                            return `${tooltipItem.label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
    
                    // Display summary
                    document.getElementById('chartSummary').innerText = `Attendance: ${data.attend} / ${data.total_days}`;
                })
                .catch(error => console.error('Error fetching data:', error));
        </script>
    </body> -->
    <!-- About Start -->
    <!-- <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="img/about.jpg" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                    <h1 class="mb-4">Welcome to eLEARNING</h1>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>International Certificate</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>International Certificate</p>
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




    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="">About SeKAD</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Sekolah USO, Nazi Camp</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>SMKUso@gmail.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Receive an email if theres any News</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">SeKAD</a>, All Right Reserved.


                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="AssignStudent.php">Home</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                            <a href="">FQAs</a>
                        </div>
                    </div>
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
