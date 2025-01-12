<?php
session_start(); // Start the session
include('db_connection.php'); // Include database connection

    
    // Retrieve user data from the session
    $name = htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8');
    $mobilenumber = htmlspecialchars($_SESSION['mobilenumber'], ENT_QUOTES, 'UTF-8');
    $emergencymobilenumber = htmlspecialchars($_SESSION['emergencymobilenumber'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $role = htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8');
    $class = htmlspecialchars($_SESSION['class'] ?? 'Not Assigned', ENT_QUOTES, 'UTF-8');
    $date_of_birth = htmlspecialchars($_SESSION['date_of_birth'] ?? 'Not Provided', ENT_QUOTES, 'UTF-8');
    $gender = htmlspecialchars($_SESSION['gender'] ?? 'Not Specified', ENT_QUOTES, 'UTF-8');
    $ic_number = htmlspecialchars($_SESSION['ic_number'] ?? 'Not Available', ENT_QUOTES, 'UTF-8');
    $nationality = htmlspecialchars($_SESSION['nationality'], ENT_QUOTES, 'UTF-8');
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

    // Ensure the session variable for name is set
    $full_name = $_SESSION['name'] ?? 'User'; // Fallback to 'User' if the name is not set
    $first_name = explode(' ', $full_name)[0]; // Extract the first name
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profile</title>
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
    <!-- Header End -->
     
    <div style="width: 90%; margin: 0 auto;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="card-title" style="font-size: 20px; text-align: left; margin-bottom: 0;">Biodata</h4>
        <a href="editProfile.blade.php" class="btn btn-primary py-md-3 px-md-5 animated slideInLeft" style="color: white;">Edit Profile</a>
    </div>

    <table class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th style="width: 150px;">Name</th>
                                            <td><?php echo $name; ?></td>
                                            
                                        </tr>
                                         <tr>
                                            <th style="width: 150px;">Date of Birth</th>
                                            <td><?php echo htmlspecialchars($_SESSION['date_of_birth']); ?></td>
                                            
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Gender</th>
                                            <td><?php echo $gender; ?></td>
                                            
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Identification Card Number</th>
                                            <td><?php echo $ic_number; ?></td>
                                            
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Nationality</th>
                                            <td><?php echo $nationality; ?></td>
                                           
                                            
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Address</th>
                                            <td><?php echo $address; ?></td>
                                            
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Role</th>
                                            <td><?php echo $role; ?></td>
                                        
                                            
                                        </tr>
                                        <?php    if ($role === 'Student'): ?>
                                        <tr>
                                            <th style="width: 150px;">Class</th>
                                            <td><?php echo $class; ?></td>
                                        </tr>

                                        <?php    elseif ($role === 'Teacher'): ?>
                                            <tr>
                                            <th style="width: 150px;">Class Teacher</th>
                                            <td><?php echo $class; ?></td>
                                            </tr>

                                        <?php    elseif ($role === 'Staff'): ?>
                                        <tr>
                                        <th style="width: 150px;">Location</th>
                                        <td><?php echo $class; ?></td>
                                        </tr>

                                        <?php    elseif ($role === 'Admin'): ?>
                                        <?php endif; ?>

                                        <tr>
                                            <th style="width: 150px;">Contact</th>
                                            <td><?php echo $mobilenumber; ?></td>
                                        </tr>

                                        <tr>
                                            <th style="width: 150px;">Email</th>
                                            <td><?php echo $email; ?></td>
                                        </tr>
                                        


                                        </tbody>
                                    </table>
                                    </div>
                                

                                    <div style="width: 90%; margin: 0 auto;">
    <h4 class="card-title" style="font-size: 20px; text-align: left; margin-bottom: 20px;">Family Information</h4>
    <table class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <th style="width: 150px;">Father's Name</th>
                                            <td><?php echo $fname; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Father's Contact</th>
                                            <td><?php echo $fcontact; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Father's Occupation</th>
                                            <td><?php echo $foccupation; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Mother's Name</th>
                                            <td><?php echo $mname; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Mother's Contact</th>
                                            <td><?php echo $mcontact; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Mother's Occupation</th>
                                            <td><?php echo $moccupation; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Guardian's Name</th>
                                            <td><?php echo $gname; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Guardian's Contact</th>
                                            <td><?php echo $gcontact; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Guardian's Occupation</th>
                                            <td><?php echo $goccupation; ?></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    </div>

                                    <div style="width: 90%; margin: 0 auto;">
    <h4 class="card-title" style="font-size: 20px; text-align: left; margin-bottom: 20px;">Health Information</h4>
    <table class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <th style="width: 150px;">Blood Type</th>
                                            <td><?php echo $blood_type; ?></td>
                                        </tr>
                                        <tr>
                                            <th style="width: 150px;">Allergies</th>
                                            <td><?php echo $allergies; ?></td>
                                        </tr>
                                        
                                    </tbody>
                                    </table>
                                    </div>

                                  
    <!-- Team End -->

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
    <!-- <script>
        // Example: Simulated authenticated user data
        const authenticatedUser = {
            name: "John Doe"
        };

        // Insert user name into the HTML
        document.getElementById("user-name").textContent = `Welcome, ${authenticatedUser.name}`;
    </script> -->
</body>

</html>