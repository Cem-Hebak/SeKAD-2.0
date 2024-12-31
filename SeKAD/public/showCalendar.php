<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Booking Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <style>
        #calendar {
            max-width: 900px;
            margin: 40px auto;
            min-height: 500px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Venue Booking Calendar</h1>
    <div id="calendar"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Month view
                events: function (fetchInfo, successCallback, failureCallback) {
                // Fetch events from the backend
                    fetch('get_bookings.php')
                        .then(response => response.json())
                        .then(data => {
                            successCallback(data); // Pass data to FullCalendar
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
                eventColor: '#FF5733', // Customize booked date color
                eventTextColor: '#ffffff' // Text color for events
            });

            calendar.render();
        });
    </script>
</body>
</html>
