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

        .fc-daygrid-event {
            cursor: pointer;
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
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    // Fetch events from the backend
                    fetch('get_bookings.php')
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch');
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) throw new Error(data.error);
                            successCallback(data); // Pass data to FullCalendar
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
                eventColor: '#FF5733', // Customize booked date color
                eventTextColor: '#ffffff', // Text color for events
                eventClick: function (info) {
                    alert(`Event: ${info.event.title}\nStart: ${info.event.start}\nEnd: ${info.event.end}`);
                },
                loading: function (isLoading) {
                    if (isLoading) {
                        console.log('Loading events...');
                    }
                }
            });

            calendar.render();
        });
    </script>
</body>
</html>
