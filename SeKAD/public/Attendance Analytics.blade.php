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
    <title>Attendance Analytics</title>
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
     
    
<!-- google chart start-->
<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Initialize database connection
$link = mysqli_connect("localhost", "root", "", "admin");

// Check connection
if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize variables
$test = array();
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : null;
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : null;
$chartType = isset($_POST['chart_type']) ? $_POST['chart_type'] : 'column'; // Default to column chart
$selectedYear = isset($_POST['year']) ? $_POST['year'] : null;
$selectedClass = isset($_POST['class_type']) ? $_POST['class_type'] : null;
$viewType = isset($_POST['view_type']) ? $_POST['view_type'] : 'both'; // Default to show both

// Check if filtering parameters are provided
if ($startDate && $endDate) {
    // Validate the dates
    if (strtotime($startDate) > strtotime($endDate)) {
        die("Start date must be earlier than or equal to end date.");
    }

    // Prepare the query to filter data by date range, year, and class
    $query = "SELECT 
                DATE(date) AS date, 
                SUM(CASE WHEN present = 1 OR present = 4 THEN 1 ELSE 0 END) AS count_1, -- Present
                SUM(CASE WHEN present = 2 OR present = 3 OR present = 5 OR present = 6 OR present = 7 THEN 1 ELSE 0 END) AS count_2  -- Absent
              FROM attendance 
              WHERE DATE(date) BETWEEN '$startDate' AND '$endDate'";

    // Add filtering conditions for year and class
    if ($selectedYear) {
        $query .= " AND class LIKE '$selectedYear%'";
    }
    if ($selectedClass) {
        $query .= " AND class LIKE '%$selectedClass'";
    }

    $query .= " GROUP BY DATE(date)
                ORDER BY DATE(date);";

    $res = mysqli_query($link, $query);

    // Check if the query execution is successful
    if ($res) {
        // Fetch the results and format them for the chart
        while ($row = mysqli_fetch_assoc($res)) {
            $test[] = [
                "label" => $row["date"],
                "y" => (int)$row["count_1"], // Present
                "absent" => (int)$row["count_2"] // Absent
            ];
        }
    } else {
        die("Query failed: " . mysqli_error($link));
    }
}

// Close the database connection
mysqli_close($link);
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
    var dataPoints = <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>;

    var chartData = [];
    var viewType = "<?php echo $viewType; ?>";

    // Build chart data based on viewType
    if (viewType === "present" || viewType === "both") {
        chartData.push({
            type: "<?php echo $chartType; ?>", // Use the selected chart type
            indexLabelFontColor: "#5A5757",
            indexLabelPlacement: "outside",
            name: "Present",
            showInLegend: true,
            color: "#4f81bc",
            dataPoints: dataPoints.map(dp => ({ label: dp.label, y: dp.y }))
        });
    }
    if (viewType === "absent" || viewType === "both") {
        chartData.push({
            type: "<?php echo $chartType; ?>", // Use the selected chart type
            indexLabelFontColor: "#5A5757",
            indexLabelPlacement: "outside",
            name: "Absent",
            showInLegend: true,
            color: "#c0504e",
            dataPoints: dataPoints.map(dp => ({ label: dp.label, y: dp.absent }))
        });
    }

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light1",
        title: {
            text: "Attendance Chart"
        },
        axisY: {
            includeZero: true
        },
        data: chartData
    });
    chart.render();
}
</script>
</head>
<body style="margin: 0; padding: 0; box-sizing: border-box;">
<table align="center" style="width: 100%; max-width: 1000px; margin: auto; border-collapse: collapse;">
    <tr>
        <td>
            <h2 style="text-align: center; margin: 20px 0;">Filter Attendance by Date, Year, Class, and View Type</h2>
            <form method="POST" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; align-items: center;">
                <div style="flex: 1; min-width: 200px; text-align: left;">
                    <label for="start_date" style="display: block; font-weight: bold; margin-bottom: 5px;">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" value="<?php echo $startDate; ?>" required 
                           style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>
                <div style="flex: 1; min-width: 200px; text-align: left;">
                    <label for="end_date" style="display: block; font-weight: bold; margin-bottom: 5px;">End Date:</label>
                    <input type="date" id="end_date" name="end_date" value="<?php echo $endDate; ?>" required 
                           style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>
                <div style="flex: 1; min-width: 200px; text-align: left;">
                    <label for="year" style="display: block; font-weight: bold; margin-bottom: 5px;">Year:</label>
                    <select id="year" name="year" style="width: 100%; padding: 8px; box-sizing: border-box;">
                        <option value="">All</option>
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php echo $selectedYear == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px; text-align: left;">
                    <label for="class_type" style="display: block; font-weight: bold; margin-bottom: 5px;">Class:</label>
                    <select id="class_type" name="class_type" style="width: 100%; padding: 8px; box-sizing: border-box;">
                        <option value="">All</option>
                        <?php foreach (['SARJANA', 'CENDEKIAWAN', 'PENDETA', 'INTELEK'] as $class) { ?>
                            <option value="<?php echo $class; ?>" <?php echo $selectedClass == $class ? 'selected' : ''; ?>><?php echo $class; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px; text-align: left;">
                    <label for="view_type" style="display: block; font-weight: bold; margin-bottom: 5px;">View Type:</label>
                    <select id="view_type" name="view_type" onchange="this.form.submit()" 
                            style="width: 100%; padding: 8px; box-sizing: border-box;">
                        <option value="both" <?php echo $viewType === 'both' ? 'selected' : ''; ?>>Both</option>
                        <option value="present" <?php echo $viewType === 'present' ? 'selected' : ''; ?>>Present Only</option>
                        <option value="absent" <?php echo $viewType === 'absent' ? 'selected' : ''; ?>>Absent Only</option>
                    </select>
                </div>
                <div style="flex: 1; min-width: 200px; text-align: left;">
                    <label for="chart_type" style="display: block; font-weight: bold; margin-bottom: 5px;">Chart Type:</label>
                    <select id="chart_type" name="chart_type" onchange="this.form.submit()" 
                            style="width: 100%; padding: 8px; box-sizing: border-box;">
                        <option value="line" <?php echo $chartType === 'line' ? 'selected' : ''; ?>>Line</option>
                        <option value="column" <?php echo $chartType === 'column' ? 'selected' : ''; ?>>Column</option>
                        <option value="area" <?php echo $chartType === 'area' ? 'selected' : ''; ?>>Area</option>
                        <option value="spline" <?php echo $chartType === 'spline' ? 'selected' : ''; ?>>Spline</option>
                    </select>
                </div>
                <!-- <div style="flex: 1; min-width: 200px; text-align: left; display: flex; justify-content: center; align-items: center;"> -->
                    <button type="submit" style="background-color: #05bacb; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; width: 100%; box-sizing: border-box;">
                        Filter
                    </button>
                <!-- </div> -->
            </form>
        </td>
    </tr>
    <tr>
        <td>
            <div id="chartContainer" style="height: 500px; width: 100%;"></div>
        </td>
    </tr>
</table>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>


<!-- google chart end -->

    
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