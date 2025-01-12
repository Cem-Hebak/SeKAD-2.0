<?php
    session_start(); // Start the session
    include('db_connection.php'); 
    // $id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8') : ''; 
    // $name = isset($_SESSION['student_name']) ? htmlspecialchars($_SESSION['student_name'], ENT_QUOTES, 'UTF-8') : ''; 
    $date = isset($_SESSION['session_date']) ? htmlspecialchars($_SESSION['session_date'], ENT_QUOTES, 'UTF-8') : ''; 
    $time = isset($_SESSION['time_slot']) ? htmlspecialchars($_SESSION['time_slot'], ENT_QUOTES, 'UTF-8') : ''; 
    $status = isset($_SESSION['status']) ? htmlspecialchars($_SESSION['status'], ENT_QUOTES, 'UTF-8') : ''; 
    $id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8') : ''; 
    $name = isset($_SESSION['student_name']) ? htmlspecialchars($_SESSION['student_name'], ENT_QUOTES, 'UTF-8') : ''; 

    // Ensure the session variable for name is set
    $full_name = $_SESSION['name'] ?? 'User'; // Fallback to 'User' if the name is not set
    $first_name = explode(' ', $full_name)[0]; // Extract the first name
    $role = htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8');
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
    <link href="css/font-size.css" rel="stylesheet">

    <link id="light-mode" rel="stylesheet" href="{{ asset('css/light.css') }}">
    <link id="dark-mode" rel="stylesheet" href="{{ asset('css/dark.css') }}" disabled>
</head>

<body>
    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> -->
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

    <?php
    $id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8') : ''; 
    $name = isset($_SESSION['student_name']) ? htmlspecialchars($_SESSION['student_name'], ENT_QUOTES, 'UTF-8') : ''; 
    $dateFilter = isset($_GET['date']) ? $_GET['date'] : '';
    ?>

    <div class="container2">
    
    <div class="container mt-4">
    <div class="row">
        <!-- Filter Form Section -->
        <div class="col-md-6">
            <form method="GET" action="">
                <div class="mb-3">
                <h4 style="margin-bottom: 20px; font-family: Arial, sans-serif;">Please check the availability before submit the form</h4>
                    <input type="date" name="date" id="dateSelect" class="form-control" 
                           value="<?php echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </form>
        </div>

        <!-- Counselling Sessions Table Section -->
        <div class="col-md-6">
            <h4 style="margin-bottom: 20px; font-family: Arial, sans-serif;">Table session booked by students:</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 40%;">Date</th>
                        <th style="width: 60%;">Time</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if (!empty($dateFilter)) {
                        try {
                            // SQL query to fetch data based on the selected date
                            $sql = "SELECT session_date, time_slot, `status` 
                                    FROM counselling_sessions 
                                    WHERE `status` = 'Accepted' AND session_date = :session_date";

                            $stmt = $pdo->prepare($sql);

                            // Bind the date parameter
                            $stmt->bindParam(':session_date', $dateFilter);

                            // Execute the query
                            $stmt->execute();

                            // Fetch the data
                            $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Check if data is available
                            if (!empty($sessions)) {
                                foreach ($sessions as $session) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($session['session_date'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td>" . htmlspecialchars($session['time_slot'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2' style='text-align: center;'>No counselling sessions found for the selected date.</td></tr>";
                            }
                        } catch (PDOException $e) {
                            die("Error fetching counselling sessions: " . $e->getMessage());
                        }
                    } else {
                        echo "<tr><td colspan='2' style='text-align: center;'>Please select a date to view counselling sessions.</td></tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <h1> </h1>
    <h4 style="margin-bottom: 20px; font-family: Arial, sans-serif;">Counselling Session Booking Form</h4>

    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Retrieve messages from the session
        $error_message = $_SESSION['error_message'] ?? null;
        $success_message = $_SESSION['success_message'] ?? null;

        // Clear messages after displaying them
        unset($_SESSION['error_message'], $_SESSION['success_message']);
    ?>

    <!-- Display error message -->
        <?php if ($error_message): ?>
            <div style="color: red; margin-bottom: 15px; font-weight: bold;">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

    <!-- Display success message -->
    <?php if ($success_message): ?>
        <div style="color: green; margin-bottom: 15px; font-weight: bold;">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="update_booking.php" enctype="multipart/form-data">
        <!-- Name input -->
        <div style="margin-bottom: 15px;">
            <label for="student_name" style="font-weight: bold; display: block; margin-bottom: 5px;">Name</label>
            <input type="text" id="student_name" name="student_name" placeholder="Enter your full name" 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
        </div>

        <!-- Form dropdown -->
        <div style="margin-bottom: 15px;">
            <label for="student_form" style="font-weight: bold; display: block; margin-bottom: 5px;">Form</label>
            <select id="student_form" name="student_form" 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                <option value="" disabled selected>Select your form</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <!-- Class dropdown -->
        <div style="margin-bottom: 15px;">
            <label for="student_class" style="font-weight: bold; display: block; margin-bottom: 5px;">Class</label>
            <select id="student_class" name="student_class" 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                <option value="" disabled selected>Select your class</option>
                <option value="Pendeta">Pendeta</option>
                <option value="Sarjana">Sarjana</option>
                <option value="Intelek">Intelek</option>
                <option value="Cendekiawan">Cendekiawan</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="session_date" style="font-weight: bold; display: block; margin-bottom: 5px;">Date</label>
            <input type="date" id="session_date" name="session_date" 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="time_slot" style="font-weight: bold; display: block; margin-bottom: 5px;">Time Availability</label>
                <select id="time_slot" name="time_slot" 
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    <option value="" disabled selected>Select a time slot</option>
                    <option value="9:00 AM - 10:30 AM">9:00 a.m. - 10:30 a.m.</option>
                    <option value="11:30 AM - 1:00 PM">11:30 a.m. - 1:00 p.m.</option>
                    <option value="2:30 PM - 4:00 PM">2:30 p.m. - 4:00 p.m.</option>
                </select>
        </div>

        <!-- Reason textarea -->
        <div style="margin-bottom: 15px;">
            <label for="session_reason" style="font-weight: bold; display: block; margin-bottom: 5px;">Reason for Session</label>
                <textarea id="session_reason" name="session_reason" rows="4" placeholder="Provide the reason for the session" 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required></textarea>
        </div>

        <!-- Submit button -->
        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" style="background-color: #007BFF; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                Book Session
            </button>
        </div> 
    </form>
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


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/global.js"></script>

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
</body>

</html>