<?php
session_start();

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

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div onclick="window.location.href='announce.blade.php';" class="col-lg-2 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-1">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Maintainence Report</h5>
                        </div>
                    </div>
                </div>
                <div onclick="window.location.href='event.blade.php';" class="col-lg-2 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-1">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5  class="mb-3">Programme Submission</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    
  

    <div class="container2">
        <h4 style="margin-bottom: 20px; color: #333;">Programme Submission Form</h4>
            <form method="POST" action="update_event.php" enctype="multipart/form-data">
                <div style="margin-bottom: 15px;">
                    <label for="pic_name" style="font-weight: bold; display: block; margin-bottom: 5px;">Person in Charge / Company</label>
                    <input type="text" id="pic_name" name="pic_name" placeholder="Enter name of person or company" 
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="phone_number" style="font-weight: bold; display: block; margin-bottom: 5px;">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Enter phone number of person in charge / company" 
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="event_name" style="font-weight: bold; display: block; margin-bottom: 5px;">Event Name</label>
                    <input type="text" id="event_name" name="event_name" placeholder="Enter name of the event" 
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
                <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label for="start_date" style="font-weight: bold; display: block; margin-bottom: 5px;">Start Date</label>
                        <input type="date" id="start_date" name="start_date" 
                            style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    </div>
                    <div style="flex: 1;">
                        <label for="start_time" style="font-weight: bold; display: block; margin-bottom: 5px;">Start Time</label>
                        <input type="time" id="start_time" name="start_time" 
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    </div>
                </div>
                <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label for="finish_date" style="font-weight: bold; display: block; margin-bottom: 5px;">Finish Date</label>
                        <input type="date" id="finish_date" name="finish_date" 
                            style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    </div>
                    <div style="flex: 1;">
                        <label for="finish_time" style="font-weight: bold; display: block; margin-bottom: 5px;">Finish Time</label>
                        <input type="time" id="finish_time" name="finish_time" 
                            style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="description" style="font-weight: bold; display: block; margin-bottom: 5px;">Event Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Provide a brief description of the event" 
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required></textarea>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="poster" style="font-weight: bold; display: block; margin-bottom: 5px;">Event Poster (Optional)</label>
                    <input type="file" id="poster" name="poster" accept="image/*" 
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="submit" style="background-color: #007BFF; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                        Submit Event
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
    <script>
    function handleImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const img = new Image();
        const canvas = document.getElementById('preview-canvas');
        const ctx = canvas.getContext('2d');

        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
        };

        img.onload = function() {
            // Set the canvas size to 1366x768
            const width = 1366;
            const height = 768;

            canvas.width = width;
            canvas.height = height;

            // Calculate the scaling factor to fit the image into the canvas
            const scale = Math.min(width / img.width, height / img.height);
            const x = (width - img.width * scale) / 2;
            const y = (height - img.height * scale) / 2;

            // Draw the image onto the canvas
            ctx.clearRect(0, 0, width, height);
            ctx.drawImage(img, x, y, img.width * scale, img.height * scale);

            // Show the preview container
            document.getElementById('preview-container').style.display = 'block';
        };

        reader.readAsDataURL(file);
    }

    function downloadCroppedImage() {
        const canvas = document.getElementById('preview-canvas');
        const link = document.createElement('a');
        link.download = 'cropped-image.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>