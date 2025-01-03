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
                            handleLastRowVisibility(calendarEl); // Check for empty last row after events are loaded
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            loadingEl.textContent = 'Failed to load calendar. Please try again later.';
                            failureCallback(error);
                        });
                },
                eventMouseEnter: function (info) {
                    var tooltip = document.createElement('div');
                    tooltip.className = 'tooltip';
                    tooltip.style.position = 'absolute';
                    tooltip.style.backgroundColor = '#333';
                    tooltip.style.color = '#fff';
                    tooltip.style.padding = '10px';
                    tooltip.style.borderRadius = '5px';
                    tooltip.style.boxShadow = '0 2px 4px rgba(0,0,0,0.2)';
                    tooltip.style.zIndex = '1000';
                    tooltip.style.whiteSpace = 'pre-line';

                    tooltip.innerHTML = `
                        <div class="tooltip-header">Booking Details</div>
                        <div class="tooltip-content">
                            <strong>Venue:</strong> ${info.event.extendedProps.venue}<br>
                            <strong>Start:</strong> ${info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}<br>
                            <strong>End:</strong> ${info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                        </div>
                    `;

                    document.body.appendChild(tooltip);

                    // Position tooltip near mouse cursor
                    document.addEventListener('mousemove', moveTooltip);

                    function moveTooltip(e) {
                        tooltip.style.left = `${e.pageX + 15}px`;
                        tooltip.style.top = `${e.pageY + 15}px`;
                    }

                    info.el.addEventListener('mouseleave', function () {
                        document.body.removeChild(tooltip);
                        document.removeEventListener('mousemove', moveTooltip);
                    });
                },
                eventColor: '#28a745', // Green background for events
                eventTextColor: '#ffffff', // White text for events
                editable: false, // Disable drag-and-drop
                navLinks: true, // Enable clickable day/week views
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
</html>
