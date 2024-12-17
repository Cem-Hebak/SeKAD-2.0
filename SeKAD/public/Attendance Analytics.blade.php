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
     
    

                                  
    <!-- Team End -->
     <!-- Analytics Chart Start yang berjaya-->


     <!-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compact Attendance Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 80%;
            margin: 30px auto;
            text-align: center;
        }
        .chart-item {
            margin-bottom: 40px;
        }
        .chart-summary {
            text-align: center;
            margin-top: 10px;
            font-size: 1em;
        }
    </style>
</head>
<body>
    <div id="chartsContainer" class="chart-container"></div>

    <script>
        fetch('getAttendanceData.php')
            .then(response => response.json())
            .then(data => {
                // Access the main container
                const chartsContainer = document.getElementById('chartsContainer');

                // Process data for each class and date
                Object.keys(data).forEach(className => {
                    const classData = data[className];

                    Object.keys(classData).forEach(date => {
                        const attendance = classData[date];
                        const total = Object.values(attendance).reduce((sum, value) => sum + value, 0);

                        // Create a container for each chart
                        const chartItem = document.createElement('div');
                        chartItem.className = 'chart-item';
                        chartItem.innerHTML = `
                            <h3>${className} - ${date}</h3>
                            <canvas id="chart_${className}_${date.replace(/-/g, '_')}"></canvas>
                            <div class="chart-summary">Attendance: ${attendance.attend} / ${total}</div>
                        `;
                        chartsContainer.appendChild(chartItem);

                        // Render the chart
                        const ctx = document.getElementById(`chart_${className}_${date.replace(/-/g, '_')}`).getContext('2d');
                        new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Attendance', 'Absence', 'Pending', 'Medical Leave'],
                                datasets: [{
                                    data: [
                                        attendance.attend,
                                        attendance.absence,
                                        attendance.pending,
                                        attendance.medical
                                    ],
                                    backgroundColor: ['#4CAF50', '#FF5252', '#FFC107', '#2196F3'],
                                    borderColor: ['#4CAF50', '#FF5252', '#FFC107', '#2196F3'],
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
                                                const totalValue = total;
                                                const value = tooltipItem.raw;
                                                const percentage = ((value / totalValue) * 100).toFixed(2);
                                                return `${tooltipItem.label}: ${value} (${percentage}%)`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
                });
            })
            .catch(error => console.error('Error fetching attendance data:', error));
    </script>
</body> -->



    <!-- // Fetch attendance data from the server -->
   


    <!-- Analytics Chart End -->


    <!-- analytics chart ada filter start -->
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compact Attendance Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 40%;
            margin: 30px auto;
            text-align: center;
        }
        .chart-item {
            margin-bottom: 40px;
        }
        .chart-summary {
            text-align: center;
            margin-top: 10px;
            font-size: 1em;
        }
        .filter-container {
            text-align: center;
            margin: 20px;
        }
        select {
            margin: 5px;
            padding: 10px;
            font-size: 1em;
        }
    </style>
</head>
<body>
    <!-- Filters -->
    <div class="filter-container">
        <label for="classFilter">Filter by Class:</label>
        <select id="classFilter" >
            <option value="all">All Classes</option>
        </select>


       

        <label for="dateFilter">Filter by Date:</label>
        <select id="dateFilter">
            <option value="all">All Dates</option>
        </select>
    </div>

    <!-- Charts Container -->
    <div id="chartsContainer" class="chart-container"></div>

    <script>
        let attendanceData = {}; // To store the fetched data

        // Fetch data and initialize the page
        fetch('getAttendanceData.php')
            .then(response => response.json())
            .then(data => {
                attendanceData = data; // Save the data globally
                populateFilters(data); // Populate the dropdown filters
                renderCharts(data); // Render all charts by default
            })
            .catch(error => console.error('Error fetching attendance data:', error));

        /**
         * Populate the class and date dropdown filters
         */
        function populateFilters(data) {
            const classFilter = document.getElementById('classFilter');
            const dateFilter = document.getElementById('dateFilter');

            // Extract unique classes and dates
            const classes = Object.keys(data);
            const dates = new Set();

            classes.forEach(className => {
                Object.keys(data[className]).forEach(date => dates.add(date));
            });

            // Populate the class filter
            classes.forEach(className => {
                const option = document.createElement('option');
                option.value = className;
                option.textContent = className;
                classFilter.appendChild(option);
            });

            // Populate the date filter
            [...dates].sort().forEach(date => {
                const option = document.createElement('option');
                option.value = date;
                option.textContent = date;
                dateFilter.appendChild(option);
            });

            // Add event listeners for filters
            classFilter.addEventListener('change', () => filterCharts());
            dateFilter.addEventListener('change', () => filterCharts());
        }

        /**
         * Render charts based on selected filters
         */
        function renderCharts(filteredData) {
            const chartsContainer = document.getElementById('chartsContainer');
            chartsContainer.innerHTML = ''; // Clear existing charts

            Object.keys(filteredData).forEach(className => {
                Object.keys(filteredData[className]).forEach(date => {
                    const attendance = filteredData[className][date];
                    const total = Object.values(attendance).reduce((sum, value) => sum + value, 0);

                    // Create a container for each chart
                    const chartItem = document.createElement('div');
                    chartItem.className = 'chart-item';
                    chartItem.innerHTML = `
                        <h3>${className} - ${date}</h3>
                        <canvas id="chart_${className}_${date.replace(/-/g, '_')}"></canvas>
                        <div class="chart-summary">Attendance: ${attendance.attend} / ${total}</div>
                         
                        <div class="chart-summary">Absence: ${attendance.absence} / ${total}</div>
                        <div class="chart-summary">Pending: ${attendance.pending} / ${total}</div>
                        <div class="chart-summary">Medical Leave: ${attendance.medical} / ${total}</div>
                    `;
                    chartsContainer.appendChild(chartItem);

                    // Render the chart
                   
                    const ctx = document.getElementById(`chart_${className}_${date.replace(/-/g, '_')}`).getContext('2d');
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Attendance', 'Absence', 'Pending', 'Medical Leave'],
                            datasets: [{
                                data: [
                                    attendance.attend,
                                    attendance.absence,
                                    attendance.pending,
                                    attendance.medical
                                ],
                                backgroundColor: ['#4CAF50', '#FF5252', '#FFC107', '#2196F3'],
                                borderColor: ['#4CAF50', '#FF5252', '#FFC107', '#2196F3'],
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
                                            const totalValue = total;
                                            const value = tooltipItem.raw;
                                            const percentage = ((value / totalValue) * 100).toFixed(2);
                                            return `${tooltipItem.label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                            
                        }
                        
                    });
                    
                });

                
            });
        }

        /**
         * Filter the charts based on selected filters
         */
        function filterCharts() {
            const classFilterValue = document.getElementById('classFilter').value;
            const dateFilterValue = document.getElementById('dateFilter').value;

            const filteredData = {};

            Object.keys(attendanceData).forEach(className => {
                if (classFilterValue === 'all' || className === classFilterValue) {
                    Object.keys(attendanceData[className]).forEach(date => {
                        if (dateFilterValue === 'all' || date === dateFilterValue) {
                            if (!filteredData[className]) {
                                filteredData[className] = {};
                            }
                            filteredData[className][date] = attendanceData[className][date];
                        }
                    });
                }
            });

            renderCharts(filteredData);
        }
        function displayStudentDetails(names, containerId) {
        const detailsContainer = document.getElementById(containerId);
        detailsContainer.innerHTML = `<h4>Students (${names.length}):</h4>`;
        if (names.length === 0) {
            detailsContainer.innerHTML += '<p>No students in this category.</p>';
        } else {
            const list = document.createElement('ul');
            names.forEach(name => {
                const listItem = document.createElement('li');
                listItem.textContent = name;
                list.appendChild(listItem);
            });
            detailsContainer.appendChild(list);
        }
}
    </script>
</body>


    <!-- analytics chart ada filter end -->










    
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