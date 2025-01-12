<?php
session_start(); // Start the session
include('db_connection.php'); // Include database connection

// Retrieve user data from the session
$name = htmlspecialchars($_SESSION['name'] ?? '', ENT_QUOTES, 'UTF-8');
$role = htmlspecialchars($_SESSION['role'] ?? '', ENT_QUOTES, 'UTF-8');

// Fetch venues and facilities with a JOIN query
$query = "
    SELECT v.id AS venue_id, v.venue_picture, v.venue_name, vf.facility_name, vf.quantity
    FROM venue v
    LEFT JOIN venue_facilities vf ON v.id = vf.venue_id
";
$stmt = $pdo->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group the results by venue
$venues = [];
foreach ($rows as $row) {
    $venue_id = $row['venue_id'];
    if (!isset($venues[$venue_id])) {
        $venues[$venue_id] = [
            'venue_picture' => $row['venue_picture'],
            'venue_name' => $row['venue_name'],
            'facilities' => [],
        ];
    }
    if (!empty($row['facility_name'])) {
        $venues[$venue_id]['facilities'][] = [
            'facility_name' => $row['facility_name'],
            'quantity' => $row['quantity'],
        ];
    }
}

// Fetch bookings data
$bookingQuery = "
    SELECT
        b.id AS booking_id,
        b.venue_id,
        b.start_time,
        b.end_time, -- Include end_time
        b.booked_by AS user_name,
        b.subject,
        b.status,
        v.venue_name
    FROM booking b
    JOIN venue v ON b.venue_id = v.id
";
$bookingStmt = $pdo->prepare($bookingQuery);
$bookingStmt->execute();
$bookings = $bookingStmt->fetchAll(PDO::FETCH_ASSOC);

// Update booking status if a POST request is received
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['status'])) {
    $bookingId = intval($_POST['booking_id']);
    $status = intval($_POST['status']);
    $updateQuery = "UPDATE bookings SET status = :status WHERE id = :id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([':status' => $status, ':id' => $bookingId]);
    echo json_encode(['success' => true]);
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Venue Booking Approval</title>
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
    <!-- Spinner Start -->
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
<!--  -->
<div class="container mt-5">
    <h2>Booking Table</h2>
    <style>
        /* Ensure all table columns have the same width */
        .table th, .table td {
            text-align: center; /* Center align the text and buttons */
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
        <thead>
            <tr>
                <th>Name</th>
                <th>Venue</th>
                <th>Subject</th>
                <th>Booking Date</th>
                <th>Booking Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <?php if ($booking['status'] == 2): // Only display pending bookings ?>
                <tr>
                <td><?= htmlspecialchars($booking['user_name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($booking['venue_name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($booking['subject'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?php
                    $startTime = new DateTime($booking['start_time']);
                    echo $startTime->format('d/m/Y'); // Display date in DD/MM/YYYY format
                    ?>
                </td>
                <td>
                    <?php
                    $endTime = new DateTime($booking['end_time']);
                    echo $startTime->format('h:i A') . ' - ' . $endTime->format('h:i A'); // Booking time in 12-hour format
                    ?>
                </td>
                        <td><?= 'Pending' ?></td>
                        <td>
                            <button class="btn btn-success update-status" style=" padding: 5px 15px; font-size: 14px; background-color: #2bc5d4; border: none;" data-id="<?= $booking['booking_id'] ?>" data-status="1">Approve</button>
                            <button class="btn btn-danger update-status" style=" padding: 5px 15px; font-size: 14px; background-color: #e74c3c; border: none;" data-id="<?= $booking['booking_id'] ?>" data-status="3">Reject</button>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="container mt-5">
<h2>Reviewed Table</h2>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Venue</th>
            <th>Subject</th>
            <th>Booking Date</th>
            <th>Booking Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bookings as $booking): ?>
            <?php if ($booking['status'] == 1 || $booking['status'] == 3): // Only display approved bookings ?>
            <tr>
                <td><?= htmlspecialchars($booking['user_name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($booking['venue_name'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($booking['subject'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?php
                    $startTime = new DateTime($booking['start_time']);
                    echo $startTime->format('d/m/Y'); // Display date in DD/MM/YYYY format
                    ?>
                </td>
                <td>
                    <?php
                    $endTime = new DateTime($booking['end_time']);
                    echo $startTime->format('h:i A') . ' - ' . $endTime->format('h:i A'); // Booking time in 12-hour format
                    ?>
                </td>
                    <td> <?= $booking['status'] == 1 ? 'Approved' : 'Rejected' ?></td>
                    <td>

                        <button class="btn btn-danger delete-booking" style=" padding: 5px 15px; font-size: 14px; background-color: #e74c3c; border: none;" data-id="<?= $booking['booking_id'] ?>">Remove</button>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
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


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Attach click event to all buttons with the class 'update-status'
            document.querySelectorAll('.update-status').forEach(button => {
                button.addEventListener('click', function () {
                    // Get booking ID and status from data attributes
                    const bookingId = this.getAttribute('data-id');
                    const status = this.getAttribute('data-status');

                    // Show a confirmation dialog before proceeding
                    const confirmAction = confirm(
                        status === '1'
                            ? 'Are you sure you want to approve this booking?'
                            : status === '3'
                            ? 'Are you sure you want to reject this booking?'
                            : 'Are you sure you want to delete this booking?'
                    );

                    if (!confirmAction) return; // Exit if user cancels

                    // Send request to update_booking_status.php
                    fetch('update_booking_status.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `booking_id=${bookingId}&status=${status}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status updated successfully!');
                            location.reload(); // Reload the page to reflect changes
                        } else {
                            alert(`Failed to update status: ${data.error || 'Unknown error'}`);
                        }
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        alert('An error occurred while updating the status.');
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Attach click event to all buttons with the class 'delete-booking'
            document.querySelectorAll('.delete-booking').forEach(button => {
                button.addEventListener('click', function () {
                    const bookingId = this.getAttribute('data-id');

                    // Show a confirmation prompt before deletion
                    const confirmAction = confirm('Are you sure you want to delete this booking? This action cannot be undone.');

                    if (!confirmAction) return; // Exit if the user cancels

                    // Send the delete request to update_booking_status.php
                    fetch('update_booking_status.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `booking_id=${bookingId}&status=4` // 4 indicates delete
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Booking deleted successfully!');
                                location.reload(); // Reload the page to reflect changes
                            } else {
                                alert(`Failed to delete booking: ${data.error || 'Unknown error'}`);
                            }
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            alert('An error occurred. Please try again.');
                        });
                });
            });
        });
    </script>

</body>

</html>
