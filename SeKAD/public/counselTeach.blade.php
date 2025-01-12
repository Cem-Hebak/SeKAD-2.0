<?php
session_start();
include('connection.php');
// Ensure the session variable for name is set
$full_name = $_SESSION['name'] ?? 'User'; // Fallback to 'User' if the name is not set
$first_name = explode(' ', $full_name)[0]; // Extract the first name
$role = htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8');

// Fetch Accepted Appointments
$acceptedSessions = [];
$sqlAccepted = "
    SELECT student_name, time_slot, session_date 
    FROM counselling_sessions 
    WHERE status = 'Accepted';
";
$resultAccepted = $conn->query($sqlAccepted);
if ($resultAccepted->num_rows > 0) {
    while ($row = $resultAccepted->fetch_assoc()) {
        $acceptedSessions[] = [
            'title' => $row['student_name'] . ' (' . $row['time_slot'] . ')',
            'start' => $row['session_date'], // FullCalendar requires ISO format (YYYY-MM-DD)
        ];
    }
}

// Fetch pending appointments
$sql = "
    SELECT 
        id, 
        student_name, 
        student_form, 
        student_class, 
        time_slot, 
        session_reason, 
        session_date, 
        status 
    FROM 
        counselling_sessions 
    WHERE 
        status = 'Pending'
    ORDER BY 
        session_date, time_slot;
";

$result = $conn->query($sql);
$pendingSessions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pendingSessions[] = $row;
    }
}

// Update appointment status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = intval($_POST['id']);
    $newStatus = $_POST['status'];

    if (in_array($newStatus, ['Accepted', 'Rejected'])) {
        $updateSql = "
            UPDATE counselling_sessions 
            SET status = '{$newStatus}', updated_at = NOW() 
            WHERE id = {$appointmentId};
        ";
        if ($conn->query($updateSql)) {
            header("Location: counselTeach.blade.php");
            exit;
        } else {
            $error = "Failed to update status. Please try again.";
        }
    }
}
// nak buang accepted
// Handle deletion of accepted students
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_accepted_id'])) {
    $deleteAcceptedId = intval($_POST['delete_accepted_id']);

    $deleteSql = "
        UPDATE counselling_sessions 
        SET status = 'Rejected', updated_at = NOW() 
        WHERE id = {$deleteAcceptedId} AND status = 'Accepted';
    ";
    if ($conn->query($deleteSql)) {
        header("Location: counselTeach.blade.php"); // Redirect to refresh the page
        exit;
    } else {
        $error = "Failed to delete accepted student. Please try again.";
    }
}
$sqlAccepted = "
    SELECT id, student_name, time_slot, session_date 
    FROM counselling_sessions 
    WHERE status = 'Accepted';
";
$resultAccepted = $conn->query($sqlAccepted);
$acceptedSessionsTable = [];

if ($resultAccepted->num_rows > 0) {
    while ($row = $resultAccepted->fetch_assoc()) {
        $acceptedSessionsTable[] = $row;
    }
}
// Ensure the session variable for name is set
$full_name = $_SESSION['name'] ?? 'User'; // Fallback to 'User' if the name is not set
$first_name = explode(' ', $full_name)[0]; // Extract the first name

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<head>
<meta charset="utf-8">
    <title>Pending Counselling Session</title>
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
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Pending Counselling Sessions</h1>
                    <nav aria-label="breadcrumb">
                        
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
    <div class="container">

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Pending Appointments Table -->
        <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h4>Manage Appointments</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($pendingSessions)): ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Form</th>
                            <th>Class</th>
                            <th>Time Slot</th>
                            <th>Session Date</th>
                            <th>Reason</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingSessions as $session): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($session['student_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($session['student_form'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($session['student_class'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($session['time_slot'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($session['session_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($session['session_reason'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?php echo $session['id']; ?>">
                                    <button type="submit" name="status" value="Accepted" class="btn btn-danger btn-sm" 
                                    style=" padding: 5px 15px; font-size: 14px; background-color:#2bc5d4; border: none;">Accept</button>
                                </form>
                                <form method="POST" style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?php echo $session['id']; ?>">
                                    <button type="submit" name="status" value="Rejected"  class="btn btn-danger btn-sm" 
                                    style=" padding: 5px 15px; font-size: 14px; background-color: #e74c3c; border: none;" >Reject</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-center">No pending appointments at the moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container mt-4">
    <h2 class="text-center">Counselling Session Calendar</h2>
    <div id="calendar"></div>
    <div class="card">
            <div class="card-header text-center bg-primary text-white">
                <h4>Accepted Appointmets</h4>
            </div>
    <div class="card-body">
        <?php if (!empty($acceptedSessionsTable)): ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Time Slot</th>
                    <th>Session Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($acceptedSessionsTable as $session): ?>
                <tr>
                    <td><?php echo htmlspecialchars($session['student_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($session['time_slot'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($session['session_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="delete_accepted_id" value="<?php echo $session['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" 
                            style=" padding: 5px 15px; font-size: 14px; background-color: #e74c3c; border: none;">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-center">No accepted appointments at the moment.</p>
        <?php endif; ?>
    </div>
</div>
</div>

<!-- FullCalendar CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        // Initialize the Calendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: <?php echo json_encode($acceptedSessions); ?> // Pass PHP data to JavaScript
        });

        calendar.render();
    });
</script>
    

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
</body>
</html>
