<?php
session_start(); // Start the session
include('db_connection.php'); // Include database connection

    
    // Retrieve user data from the session
    $name = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8');
    // $email = htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8');
    // $mobilenumber = htmlspecialchars($_SESSION['mobilenumber'], ENT_QUOTES, 'UTF-8');
    // $emergencymobilenumber = htmlspecialchars($_SESSION['emergencymobilenumber'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    // $role = htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8');
    // $class = htmlspecialchars($_SESSION['class'] ?? 'Not Assigned', ENT_QUOTES, 'UTF-8');
    // $date_of_birth = htmlspecialchars($_SESSION['date_of_birth'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    // $gender = htmlspecialchars($_SESSION['gender'] ?? 'Not Specified', ENT_QUOTES, 'UTF-8');
    // $ic_number = htmlspecialchars($_SESSION['ic_number'] ?? 'Not Available', ENT_QUOTES, 'UTF-8');
    // $nationality = htmlspecialchars($_SESSION['nationality'], ENT_QUOTES, 'UTF-8');
    // $address = htmlspecialchars($_SESSION['address'] ?? 'Not Available', ENT_QUOTES, 'UTF-8');
    // $fname = htmlspecialchars($_SESSION['fname'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    // $fcontact = htmlspecialchars($_SESSION['fcontact'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    // $foccupation = htmlspecialchars($_SESSION['foccupation'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    // $mname = htmlspecialchars($_SESSION['mname'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    // $mcontact = htmlspecialchars($_SESSION['mcontact'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    // $moccupation = htmlspecialchars($_SESSION['moccupation'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    // $gname = htmlspecialchars($_SESSION['gname'] ?? 'Not Applicable', ENT_QUOTES, 'UTF-8');
    // $gcontact = htmlspecialchars($_SESSION['gcontact'] ?? 'Not Applicable', ENT_QUOTES, 'UTF-8');
    // $goccupation = htmlspecialchars($_SESSION['goccupation'] ?? 'Not Applicable', ENT_QUOTES, 'UTF-8');
    // $blood_type = htmlspecialchars($_SESSION['blood_type'] ?? 'Unknown', ENT_QUOTES, 'UTF-8');
    // $allergies = htmlspecialchars($_SESSION['allergies'] ?? 'None', ENT_QUOTES, 'UTF-8');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Low Attendance</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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

    <!-- Low Attendance css -->
    <link href="css/lowAttend.css" rel="stylesheet">
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
    <!-- Header End -->
</body>

<?php
    // session_start(); // Start the session to access session variables

    // Check if the user is logged in
    if (!isset($_SESSION['ic_number'])) {
        die("You must log in to view this page.");
    }

    // Assuming you have a database connection here
    // include 'db_connection.php'; // Include your DB connection file

    // Escape HTML output function
    function escape($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    try {
        // Define present and absent values
        $presentValues = [1, 4];
        $absentValues = [2, 3, 5, 6, 7];
        $attendanceThreshold = 75; // Threshold percentage for warnings

        // Get the logged-in student's IC number from the session
        $loggedInICNumber = $_SESSION['ic_number'];

        // Query to fetch attendance summary for the logged-in student
        $summaryQuery = "SELECT ic_number, name, 
                                COUNT(CASE WHEN present IN (" . implode(',', $presentValues) . ") THEN 1 END) AS total_attendances,
                                COUNT(CASE WHEN present IN (" . implode(',', $absentValues) . ") THEN 1 END) AS total_absences,
                                COUNT(*) AS total_records
                        FROM attendance
                        WHERE ic_number = :ic_number
                        GROUP BY ic_number, name";

        // Query to fetch absence details for the logged-in student
        $absenceDetailsQuery = "SELECT date, present, class
                                FROM attendance
                                WHERE ic_number = :ic_number AND present IN (" . implode(',', $absentValues) . ")
                                ORDER BY date ASC";

        // Prepare and execute the summary query
        $stmt = $pdo->prepare($summaryQuery);
        $stmt->execute(['ic_number' => $loggedInICNumber]);
        $summaryResults = $stmt->fetchAll();

        // Prepare and execute the absence details query
        $absenceStmt = $pdo->prepare($absenceDetailsQuery);
        $absenceStmt->execute(['ic_number' => $loggedInICNumber]);
        $absenceDetails = $absenceStmt->fetchAll();

        // Output attendance summary table
        echo "<h2 style='text-align:center;'>My Attendance Report</h2>";
        echo "<style>
                table { width: 80%; margin: auto; border-collapse: collapse; text-align: center; }
                th, td { padding: 10px; border: 1px solid #ddd; }
                th { background-color: #f2f2f2; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                span { font-weight: bold; }
            </style>";

        echo "<table>";
        echo "<tr>
                <th>IC Number</th>
                <th>Student Name</th>
                <th>Total Attendances</th>
                <th>Total Absences</th>
                <th>Attendance Percentage</th>
                <th>Status</th>
            </tr>";

        foreach ($summaryResults as $row) {
            $ic_number = escape($row['ic_number']);
            $studentName = escape($row['name']);
            $totalAttendances = $row['total_attendances'];
            $totalAbsences = $row['total_absences'];
            $totalRecords = $row['total_records'];

            // Calculate attendance percentage
            $attendancePercentage = ($totalRecords > 0) ? ($totalAttendances / $totalRecords) * 100 : 0;

            // Determine status and additional message
            $status = ($attendancePercentage < $attendanceThreshold) ? 
                    "<span style='color:red;'>Warning</span>" : "Normal";

            $additionalMessage = '';
                if ($attendancePercentage < 50) {
                    $additionalMessage = "<p style='color:red; font-weight:bold; text-align:center;'>
                                            Attendance is critically low. Please meet your class teacher to address this issue.
                                          </p>";
                }
            
            // Display additional message for low attendance
            if ($additionalMessage) {
                echo "<tr>
                        <td colspan='6'>{$additionalMessage}</td>
                    </tr>";
            }

            echo "<tr>
                    <td>{$ic_number}</td>
                    <td>{$studentName}</td>
                    <td>{$totalAttendances}</td>
                    <td>{$totalAbsences}</td>
                    <td>" . number_format($attendancePercentage, 2) . "%</td>
                    <td>{$status}</td>
                </tr>";
        }

        echo "</table>";
        echo "</br>";
        // Output absence details table
        echo "<h3 style='text-align:center;'>Absence Details</h3>";
        echo "<table>";
        echo "<tr>
                <th>Date</th>
                <th>Class</th>
                <th>Reason</th>
            </tr>";

        foreach ($absenceDetails as $absence) {
            $date = escape($absence['date']);
            $class = escape($absence['class'] ?: 'N/A');
            $reason = '';

            switch ($absence['present']) {
                case 2: $reason = 'Absence without proof'; break;
                case 3: $reason = 'Proof of absence is pending'; break;
                case 5: $reason = 'Absence due to family matter'; break;
                case 6: $reason = 'Absence due to natural disasters'; break;
                case 7: $reason = 'Other (counted as absence)'; break;
            }

            echo "<tr>
                    <td>{$date}</td>
                    <td>{$class}</td>
                    <td>{$reason}</td>
                </tr>";
        }

        echo "</table>";

    } catch (PDOException $e) {
        die("Error fetching data: " . $e->getMessage());
    }

    $pdo = null; // Close DB connection
?>

<body>
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-white mb-3">Quick Link</h4>
                        <a class="btn btn-link" href="">About Us</a>
                        <a class="btn btn-link" href="">Contact Us</a>
                        <a class="btn btn-link" href="">Privacy Policy</a>
                        <a class="btn btn-link" href="">Terms & Condition</a>
                        <a class="btn btn-link" href="">FAQs & Help</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-white mb-3">Contact</h4>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
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
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
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
                            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</body>
    <!-- Footer End -->
