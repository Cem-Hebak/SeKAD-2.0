<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Booking Calendar</title>
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="css/calendar.css">
    <!-- FullCalendar CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet"> -->
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
</head>
<body>
    <h1>Venue Booking Calendar</h1>
    <div id="loading">Loading calendar...</div>
    <div id="calendar"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var loadingEl = document.getElementById('loading');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            showNonCurrentDates: false, // Hide dates outside the current month
            events: function (fetchInfo, successCallback, failureCallback) {
                fetch('get_bookings.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch events. Status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        loadingEl.style.display = 'none'; // Hide loading indicator
                        successCallback(data); // Pass events to the calendar
                        handleLastRowVisibility(calendarEl);
                    })
                    .catch(error => {
                        console.error('Error fetching events:', error);
                        loadingEl.textContent = 'Failed to load calendar. Please try again later.';
                        failureCallback(error);
                    });
            },
            eventColor: '#28a745', // Green background for events
            eventTextColor: '#ffffff', // White text for events
            editable: false, // Disable drag-and-drop
            navLinks: true, // Enable clickable day/week views
        });

        calendar.render();

        // Function to check and hide the last row dynamically
        function handleLastRowVisibility(calendarElement) {
            // Find all rows in the calendar
            const rows = calendarElement.querySelectorAll('.fc-daygrid-body tr');
            if (rows.length > 0) {
                const lastRow = rows[rows.length - 1];
                const hasContent = Array.from(lastRow.querySelectorAll('.fc-day')).some(
                    cell => cell.textContent.trim() !== '' // Check if the cell is not empty
                );

                // Hide the last row if it contains no dates or events
                if (!hasContent) {
                    lastRow.style.display = 'none';
                } else {
                    lastRow.style.display = ''; // Ensure the row is visible if needed
                }
            }
        }
    });
    </script>
</body>
</html>
