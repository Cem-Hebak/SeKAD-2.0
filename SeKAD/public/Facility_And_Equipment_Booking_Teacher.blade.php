<?php
    session_start(); // Start the session
    include('db_connection.php'); // Include database connection

    // Retrieve user data from the session
    $name = htmlspecialchars($_SESSION['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $role = htmlspecialchars($_SESSION['role'] ?? '', ENT_QUOTES, 'UTF-8');

    // Fetch venues and facilities with a JOIN query
    $query = "
    SELECT v.id AS venue_id, v.venue_picture, v.venue_name, v.venue_type, vf.facility_name, vf.quantity
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
            'venue_type' => $row['venue_type'] ?? 'Unknown',
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

    $error_message = ''; // Initialize error message variable

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $venue_id = $_POST['venue_id'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $booked_by = $_POST['booked_by'];
        $subject = $_POST['subject'];

        // Check if the venue is already booked at the selected time
        $stmt = $pdo->prepare("SELECT * FROM booking 
                            WHERE venue_id = :venue_id 
                            AND ((start_time < :end_time AND end_time > :start_time))");
        $stmt->execute([
            ':venue_id' => $venue_id,
            ':start_time' => $start_time,
            ':end_time' => $end_time,
        ]);
        $existing_booking = $stmt->fetch();

        // If an overlapping booking exists, set the error message
        if ($existing_booking) {
            $error_message = "The selected time for the venue is already booked.";
        } else {
            // If no conflict, proceed with the booking
            $stmt = $pdo->prepare("INSERT INTO booking (venue_id, start_time, end_time, booked_by, Subject) 
                                VALUES (:venue_id, :start_time, :end_time, :booked_by, :subject)");
            $stmt->execute([
                ':venue_id' => $venue_id,
                ':start_time' => $start_time,
                ':end_time' => $end_time,
                ':booked_by' => $booked_by,
                ':subject' => $subject,
            ]);

            // Success message (optional)
            $success_message = "Booking successful!";
        }

        // Fetch distinct venue types from the database
        try {
            $stmt = $pdo->query("SELECT DISTINCT venue_type FROM venue");
            $venueTypes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all venue types as an associative array
        } catch (PDOException $e) {
            // Handle errors in fetching venue types
            die("Failed to fetch venue types: " . $e->getMessage());
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Venue Booking Teacher</title>
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

    <!-- Venue Details -->
    <link rel="stylesheet" href="css/venueBook.css">    

    <!-- Calendar -->
    <link rel="stylesheet" href="css/calendar.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
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
                        <a href="attendanbce_rewards.blade.php" class="dropdown-item">Attendance Leaderboards</a>
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
<!-- Venue Booking Form Start -->
<?php    if ($role === 'Staff'): ?>
    
<div class="container2">
    <h4 style="margin-bottom: 20px; font-family: Arial, sans-serif;">Venue Booking Form</h4>

    <!-- Display error message if booking failed -->
    <?php if ($error_message): ?>
        <div style="color: red; margin-bottom: 15px; font-weight: bold;">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php elseif (isset($success_message)): ?>
        <!-- Display success message if booking succeeded -->
        <div style="color: green; margin-bottom: 15px; font-weight: bold;">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div style="margin-bottom: 15px;">
            <label for="venue_id" style="font-weight: bold; display: block; margin-bottom: 5px;">Venue</label>
            <select id="venue_id" name="venue_id" 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                <option value="">Select a Venue</option>
                <!-- Populate dynamically from the database -->
                <?php
                $stmt = $pdo->prepare("SELECT id, venue_name FROM venue");
                $stmt->execute();
                while ($venue = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"{$venue['id']}\">" . htmlspecialchars($venue['venue_name'], ENT_QUOTES, 'UTF-8') . "</option>";
                }
                ?>
            </select>
        </div>
        <div style="display: flex; gap: 20px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label for="start_time" style="font-weight: bold; display: block; margin-bottom: 5px;">Start Time</label>
                <input type="datetime-local" id="start_time" name="start_time" 
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </div>
            <div style="flex: 1;">
                <label for="end_time" style="font-weight: bold; display: block; margin-bottom: 5px;">End Time</label>
                <input type="datetime-local" id="end_time" name="end_time" 
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </div>
        </div>
        <div style="margin-bottom: 15px;">
            <label for="booked_by" style="font-weight: bold; display: block; margin-bottom: 5px;">Booked By</label>
            <input type="text" id="booked_by" name="booked_by" placeholder="Enter your name or ID" 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label for="subject" style="font-weight: bold; display: block; margin-bottom: 5px;">Subject</label>
            <input type="text" id="subject" name="subject" placeholder="State reasons for booking" 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
        </div>
        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" style="background-color: #007BFF; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                Submit Booking
            </button>
        </div>
    </form>
</div>

<?php endif; ?>
<!-- Venue Booking Form End -->
    <!-- Venue Booking Start -->
    <?php    if ($role === 'Staff'): ?>
        <!-- color: "#c0504e" -->
        <div class="d-flex justify-content-center my-4">
            <a href="registerVenue.blade.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" style="color: white; text-align: left;">Register Venue</a>
            <a href="DeleteVenue.blade.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft" style="background-color: #c0504e; color: white; text-align: left;">Remove Venue</a>
            <?php endif; ?>
    </div> 

    <body>
        <h1 style="margin: 60px 0 0 ;">List of Venue</h1>
    </body>
    <!-- Venue filter dropdown -->
    <div class="dropdown-container_venue">
        <div>
            <label for="venue_type_filter">Venue Type:</label>
            <select id="venue_type_filter" name="venue_type_filter">
                <option value="">Select Venue Type</option>
                <option value="Activity">Activity Rooms</option>
                <option value="General">General Areas</option>
                <option value="Hostel">Hostel Areas</option>
                <option value="Learning">Learning Areas</option>
                <option value="Library">Library Areas</option>
                <option value="Meeting">Meeting Areas</option>
                <option value="Sport">Sport Areas</option>
                <option value="Support">Religious and Support Areas</option>
                <option value="Office">Teacher and Office Areas</option>
                <option value="Teacher">Teacher Quarters</option>
            </select>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4" id="venueCardsContainer">
                <?php foreach ($venues as $index => $venue): ?>
                    <div 
                        class="col-lg-4 col-sm-6 venue-card" 
                        data-index="<?php echo $index; ?>" 
                        data-name="<?php echo htmlspecialchars($venue['venue_name'], ENT_QUOTES, 'UTF-8'); ?>" 
                        data-picture="<?php echo htmlspecialchars($venue['venue_picture'], ENT_QUOTES, 'UTF-8'); ?>" 
                        data-type="<?php echo htmlspecialchars($venue['venue_type'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-facilities='<?php echo json_encode($venue['facilities'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>'
                    >
                        <div class="service-item">
                            <div class="img-container">
                                <img class="img-fluid" src="<?php echo htmlspecialchars($venue['venue_picture'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                            </div>
                            <h5 class="venue-name"><?php echo htmlspecialchars($venue['venue_name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="venueModal" class="custom-modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div class="modal-body">
                <div class="img-container">
                    <img id="modalVenuePicture" class="img-fluid" alt="">
                </div>
                <h5 id="modalVenueName"></h5>
                <ul id="modalVenueFacilities"></ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const venueCards = document.querySelectorAll('.venue-card');
            const modal = document.getElementById('venueModal');
            const closeModalBtn = document.querySelector('.close-btn');
            const modalVenuePicture = document.getElementById('modalVenuePicture');
            const modalVenueName = document.getElementById('modalVenueName');
            const modalVenueFacilities = document.getElementById('modalVenueFacilities');
            const venueTypeFilter = document.getElementById('venue_type_filter');

            // Filter Venue Cards
            venueTypeFilter.addEventListener('change', () => {
                const selectedType = venueTypeFilter.value.toLowerCase();
                venueCards.forEach(card => {
                    const venueType = card.getAttribute('data-type').toLowerCase();
                    if (selectedType === '' || venueType === selectedType) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // Open Modal and Populate Data
            venueCards.forEach(card => {
                card.addEventListener('click', () => {
                    const venueName = card.getAttribute('data-name');
                    const venuePicture = card.getAttribute('data-picture');
                    const facilities = JSON.parse(card.getAttribute('data-facilities'));

                    modalVenueName.textContent = venueName;
                    modalVenuePicture.src = venuePicture;

                    modalVenueFacilities.innerHTML = '';
                    facilities.forEach(facility => {
                        const li = document.createElement('li');
                        li.textContent = `${facility.facility_name}: ${facility.quantity}`;
                        modalVenueFacilities.appendChild(li);
                    });

                    modal.style.display = 'flex';
                });
            });

            // Close Modal
            closeModalBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            // Close Modal on Click Outside Content
            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
        </script>
     
<!-- Calendar Start -->
<?php
    // Fetch distinct venue types from the database
    try {
        $stmt = $pdo->query("SELECT DISTINCT venue_type FROM venue");
        $venueTypes = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all venue types as an associative array
    } catch (PDOException $e) {
        // Handle errors in fetching venue types
        die("Failed to fetch venue types: " . $e->getMessage());
    }
?>

<body>
    <h1>Venue Booking Calendar</h1>
        
        <!-- Venue filter dropdown -->
        <div class = "dropdown-container">
            <div>
                <label for="venue_type">Venue Type:</label>
                    <select id="venue_type" name="venue_type" required>
                        <option value="">Select Venue Type</option>
                        <option value="Activity">Activity Rooms</option>
                        <option value="General">General Areas</option>
                        <option value="Hostel">Hostel Areas</option>
                        <option value="Learning">Learning Areas</option>
                        <option value="Library">Library Areas</option>
                        <option value="Meeting">Meeting Areas</option>
                        <option value="Sport">Sport Areas</option>
                        <option value="Support">Religious and Support Areas</option>
                        <option value="Office">Teacher and Office Areas</option>
                        <option value="Teacher">Teacher Quarters</option>
                    </select>
            </div>
        </div>

        <div id="loading">Loading calendar...</div>
        <div id="calendar"></div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var loadingEl = document.getElementById('loading');
                var venueType = document.getElementById('venue_type');

                venueType.addEventListener('change', function () {
                    const selectedVenueType = venueType.value;
                    calendar.removeAllEventSources(); // Clear previous events
                    calendar.addEventSource(fetchEvents(selectedVenueType)); // Add new events based on venue type
                    calendar.refetchEvents(); // Refetch events
                });

                function fetchEvents(venueType) {
                    return function (fetchInfo, successCallback, failureCallback) {
                        fetch(`get_bookings.php?venue_type=${venueType || ''}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to fetch events. Status: ' + response.status);
                                }
                                return response.json();
                            })
                            .then(data => {
                                loadingEl.style.display = 'none'; // Hide loading indicator
                                successCallback(data);
                            })
                            .catch(error => {
                                console.error('Error fetching events:', error);
                                loadingEl.textContent = 'Failed to load calendar. Please try again later.';
                                failureCallback(error);
                            });
                    };
                }

                // venueFilter.addEventListener('change', function () {
                //     const selectedVenue = venueFilter.value;
                //     calendar.removeAllEventSources(); // Clear previous events
                //     calendar.addEventSource(fetchEvents(selectedVenue)); // Add new events based on venue
                //     calendar.refetchEvents(); // Refetch events
                // });

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },

                    showNonCurrentDates: false, // Hide dates outside the current month
                    events: fetchEvents(venueType ? venueType.value : ''), 
                    // Format event content to display time properly
                    eventContent: function (info) {
                        const startTime = new Date(info.event.start).toLocaleTimeString([], {
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true, // Enables 'am/pm' format
                        });

                        return {
                            html: `<div>${startTime} (${info.event.title})</div>`, // Properly formatted time + title
                        };
                    },

                    eventMouseEnter: function (info) {
                        var tooltip = document.createElement('div');
                        tooltip.className = 'tooltip';
                        tooltip.innerHTML = `
                        <div><strong>Booking Details</strong></div>
                        <div><strong>Venue:</strong> ${info.event.extendedProps.venue}</div>
                        <div><strong>From:</strong> ${info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true })}</div>
                        <div><strong>To:</strong> ${info.event.end ? info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true }) : 'N/A'}</div>
                        <div><strong>Booked by:</strong> ${info.event.extendedProps.booked_by}</div>
                        `;
                        document.body.appendChild(tooltip);

                        function moveTooltip(e) {
                            tooltip.style.left = `${e.pageX + 10}px`; // Offset tooltip from cursor
                            tooltip.style.top = `${e.pageY + 10}px`;
                        }

                        document.addEventListener('mousemove', moveTooltip);

                        function removeTooltip() {
                            tooltip.remove();
                            document.removeEventListener('mousemove', moveTooltip);
                            info.el.removeEventListener('mouseleave', removeTooltip);
                        }

                        info.el.addEventListener('mouseleave', removeTooltip);
                    },
                    eventColor: '#28a745',
                    eventTextColor: '#ffffff',
                    editable: false,
                    navLinks: true,
                    datesSet: function () {
                        handleLastRowVisibility(calendarEl); // Check after each view change
                    }
                });

                calendar.render();

                // Function to check and hide the last row dynamically
                function handleLastRowVisibility(calendarElement) {
                    // Wait for the calendar DOM to fully render
                    setTimeout(() => {
                        const rows = calendarElement.querySelectorAll('.fc-daygrid-body tr');
                        if (rows.length > 0) {
                            const lastRow = rows[rows.length - 1];
                            const hasContent = Array.from(lastRow.querySelectorAll('.fc-day')).some(
                                cell => cell.classList.contains('fc-daygrid-day') && cell.textContent.trim() !== ''
                            );

                            // Hide the last row if it contains no dates or events
                            if (!hasContent) {
                                lastRow.style.display = 'none';
                            } else {
                                lastRow.style.display = ''; // Ensure the row is visible if needed
                            }
                        }
                    }, 10); // Small delay to ensure DOM is updated
                }
            });
        </script>
</body>
 <!-- Calendar End -->





<!-- Venue Booking End -->


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