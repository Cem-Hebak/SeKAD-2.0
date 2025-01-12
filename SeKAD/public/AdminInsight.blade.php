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
    try {
        // Prepare the query to count users by role
        $query = "SELECT role, COUNT(*) AS count FROM users GROUP BY role";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    
        // Fetch results
        $roleCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Initialize default counts for roles
        $counts = [
            'Student' => 0,
            'Teacher' => 0,
            'Staff' => 0,
            'Admin' => 0
        ];
    
        // Populate counts from the database results
        foreach ($roleCounts as $row) {
            $role = $row['role'];
            $count = $row['count'];
            $counts[$role] = $count;
        }
    
         // Prepare the query to count venues by type
    $venueQuery = "SELECT venue_type AS Venue_Type, COUNT(*) AS Count FROM venue GROUP BY venue_type";
    $venueStmt = $pdo->prepare($venueQuery);
    $venueStmt->execute();

    // Fetch venue type counts
    $venueCounts = $venueStmt->fetchAll(PDO::FETCH_ASSOC);
    
    } catch (PDOException $e) {
        die("Error fetching role counts: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
    }
    
    // Close the database connection
    $pdo = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Insight</title>
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

    <!-- Google Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="courses.html" class="nav-item nav-link">Courses</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="Teacher Assign.blade.php" class="dropdown-item">Teacher Assign</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                        <a href="profile.blade.php" class="dropdown-item">Profile</a>
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
     
<!-- Admin Insight Start -->
<div style="width: 90%; margin: 0 auto; display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">
  <table  style="width: 100%; border-collapse: collapse; background-color: #fff; box-shadow: 00 4px 8px rgba(0, 0, 0, .1);">
    <tr>
      <td style="padding: 16px; text-align: left; vertical-align: top; width: 50%;">
        <div style="background-color: #f9f9f9; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title" style="font-size: 20px; text-align: left; margin-bottom: 0; color: #333;">Number of Users</h4>
          </div>

          <table class="table table-striped table-bordered" style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr style="background-color: #05b9c7; color: white;">
                <th style="width:50%; padding: 12px; text-align: left;">Role</th>
                <th style="width:50%; padding: 12px; text-align: left;">Count</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($counts as $role => $count): ?>
                <tr>
                  <td style="padding: 12px; display: flex; align-items: center;">
                    <?php if ($role === 'Student'): ?>
                      <i class="fas fa-user-graduate" style="margin-right: 10px; color: #4CAF50;"></i>
                    <?php elseif ($role === 'Teacher'): ?>
                      <i class="fas fa-chalkboard-teacher" style="margin-right: 10px; color: #F44336;"></i>
                    <?php elseif ($role === 'Staff'): ?>
                      <i class="fas fa-users-cog" style="margin-right: 10px; color: #FF9800;"></i>
                    <?php elseif ($role === 'Admin'): ?>
                      <i class="fas fa-user-shield" style="margin-right: 10px; color: #03A9F4;"></i>
                    <?php endif; ?>
                    <?php echo htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?>
                  </td>
                  <td style="padding: 12px;"><?php echo htmlspecialchars($count, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </td>

      <td rowspan="2" style="padding: 16px; text-align: left; vertical-align: top; width: 50%;">
        <div style="background-color: #f9f9f9; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
          <label for="chartType" class="card-title" style="font-size: 20px; text-align: left; margin-bottom: 10px; color: #333;">Select Chart Type:</label>
          <select id="chartType" style="width: 100%; padding: 12px; border-radius: 4px; border: 1px solid #ccc; margin-bottom: 20px;">
            <option value="pie">Pie</option>
            <option value="bar">Bar</option>
            <option value="line">Line</option>
            <option value="doughnut">Doughnut</option>
          </select>
          <canvas id="userChart" style="width: 100%; height: 200px;"></canvas>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding: 16px; text-align: left; vertical-align: top;">
        <div style="width: 100%; display: flex; justify-content: space-between; gap: 20px;">
          <div style="width: 100%; background-color: #f9f9f9; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <h4 class="card-title" style="font-size: 20px; text-align: left; margin-bottom: 0; color: #333;">Number of Venues</h4>
            <table class="table table-striped table-bordered" style="width: 100%; border-collapse: collapse;">
              <thead>
                <tr style="background-color: #05b9c7; color: white;">
                  <th style="width:50%; padding: 12px; text-align: left;">Venue Type</th>
                  <th style="width:50%; padding: 12px; text-align: left;">Count</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($venueCounts as $venue): ?>
                  <tr>
                    <td style="padding: 12px;"><?php echo htmlspecialchars($venue['Venue_Type'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td style="padding: 12px;"><?php echo htmlspecialchars($venue['Count'], ENT_QUOTES, 'UTF-8'); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </td>
    </tr>
  </table>
</div>
<!-- Admin Insight End -->

    <!-- Table Section -->
    

    <!-- Chart Section -->
   



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
    // Prepare the data for the chart
    const userRoles = <?php echo json_encode(array_keys($counts), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    const userCounts = <?php echo json_encode(array_values($counts), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

    // Get the chart canvas
    const ctx = document.getElementById('userChart').getContext('2d');

    // Initial chart type
    let currentChartType = 'pie';

    // Create the chart instance
    let userChart = new Chart(ctx, {
        type: currentChartType,
        data: {
            labels: userRoles,
            datasets: [{
                label: 'Number of Users',
                data: userCounts,
                backgroundColor: [
                    '#4CAF50',
                    '#F44336',
                    '#FF9800',
                    '#03A9F4'
                ],
                borderColor: ['white'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label}: ${value}`;
                        }
                    }
                }
            }
        }
    });

    // Add event listener to dynamically change chart type
    document.getElementById('chartType').addEventListener('change', function () {
        const newChartType = this.value;

        // Destroy the current chart instance
        userChart.destroy();

        // Create a new chart with the selected type
        userChart = new Chart(ctx, {
            type: newChartType,
            data: {
                labels: userRoles,
                datasets: [{
                    label: 'Number of Users',
                    data: userCounts,
                    backgroundColor: [
                        '#4CAF50',
                        '#F44336',
                        '#FF9800',
                        '#03A9F4'
                    ],
                    borderColor: ['white'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            }
        });

        currentChartType = newChartType;
    });
</script>
<!-- Admin Insight End -->

<!-- user chart end -->




    
<!-- Admin Insight End -->

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