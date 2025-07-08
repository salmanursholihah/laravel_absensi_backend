<!DOCTYPE html>
<html>

<head>
    <title>Laravel Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.css" rel="stylesheet">
</head>

<body>

    <h1>My Calendar</h1>
    <div id='calendar'></div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/events',
            selectable: true,
            select: function(info) {
                var title = prompt('Event Title:');
                if (title) {
                    fetch('/events', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                title: title,
                                start: info.startStr,
                                end: info.endStr
                            })
                        }).then(response => response.json())
                        .then(data => {
                            calendar.refetchEvents();
                        });
                }
            }
        });

        calendar.render();
    });
    </script>
</body>

</html>