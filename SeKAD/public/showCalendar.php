<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Booking Calendar</title>
    <!-- FullCalendar CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet"> -->
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <style>
        #calendar {
            max-width: 900px;
            margin: 40px auto;
            min-height: 500px;
        }

        .fc-daygrid-event {
            cursor: pointer;
        }

        #loading {
            text-align: center;
            color: #666;
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Venue Booking Calendar</h1>
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
                events: function (fetchInfo, successCallback, failureCallback) {
                    // Fetch events from get_bookings.php
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
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            loadingEl.textContent = 'Failed to load calendar. Please try again later.';
                            failureCallback(error);
                        });
                },
                eventColor: '#FF5733', // Styling for event background
                eventTextColor: '#ffffff', // Styling for event text
                editable: false, // Disable drag-and-drop
                navLinks: true, // Enable clickable day/week views
            });

            calendar.render();
        });
    </script>
</body>
</html>
