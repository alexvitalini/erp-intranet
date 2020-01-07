<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />

    <link href='plugins/fullcalendar/core/main.css' rel='stylesheet' />
    <link href='plugins/fullcalendar/daygrid/main.css' rel='stylesheet' />

    <script src='plugins/fullcalendar/core/main.js'></script>
    <script src='plugins/fullcalendar/daygrid/main.js'></script>

    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'dayGrid' ]
        });
		calendar.setOption('locale', 'es');
        calendar.render();
      });

    </script>
  </head>
  <body>

    <div id='calendar'></div>

  </body>
</html>