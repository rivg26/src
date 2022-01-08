<?php

require_once 'includes/dbh.inc.php';

function getDeliveryDate($conn)
{
    $sql = "SELECT delivery_table.delivery_sales_invoice, delivery_table.delivery_date, delivery_table.delivery_status, CONCAT(customer_table.customer_last_name, ', ', customer_table.customer_first_name, ' ', substr(customer_table.customer_last_name,1,1),'.') AS 'customer_name' FROM `sales_table` JOIN delivery_table ON delivery_table.delivery_sales_invoice = sales_invoice JOIN customer_table ON customer_table.customer_id = sales_customer_id ORDER BY delivery_date ASC;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../funtions.inc.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $rows[] = $row;
    }
    return $rows;
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

$data = getDeliveryDate($conn);


?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css" integrity="sha256-zsz1FbyNCtIE2gIB+IyWV7GbCLyKJDTBRz0qQaBSLxM=" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'>
    <script>
        var myArray = [];

        function getDeliveryData() {
            var wholeData = <?= json_encode($data) ?>;

            for (let x = 0; x < wholeData.length; x++) {
                var hello = {
                    title: wholeData[x]['customer_name'] + '---' + wholeData[x]['delivery_status'] ,
                    start: wholeData[x]['delivery_date'],
                }
                myArray.push(hello)

            }
        }
        getDeliveryData();
        draw();

        function draw() {
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');



                var calendar = new FullCalendar.Calendar(calendarEl, {
                    themeSystem: 'bootstrap',
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        start: 'Paredes Petron Calendar',
                        left: 'prev next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    googleCalendarApiKey: 'AIzaSyCxID7BTR6z_WWwgNs7pFLfJca89adkRfo',
                    eventSources: [{
                        googleCalendarId: 'gregorioron26@gmail.com',

                    }],
                    events: myArray,
                    windowResize: function(arg) {
                        alert('The calendar has adjusted to a window resize. Current view: ' + arg.view.type);
                    }
                });
                calendar.render();
            });
        }
    </script>
    <script>
        // var calendarEl = document.getElementById('calendar');
        // var calendar = new Calendar(calendarEl, {
        //     plugins: [googleCalendarPlugin],
        //     googleCalendarApiKey: 'AIzaSyCxID7BTR6z_WWwgNs7pFLfJca89adkRfo',
        //     events: {
        //         googleCalendarId: 'gregorioron26@gmail.com'
        //     }
        // });
        // calendar.render();
    </script>
</head>

<body>
    <div id='calendar'></div>
</body>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.js" integrity="sha256-nCXGH8kkPFozCBx4meHWhA5OCqXhhBzoBVpHfM/HmwM=" crossorigin="anonymous"></script>


</html>

<!-- AIzaSyCxID7BTR6z_WWwgNs7pFLfJca89adkRfo
gregorioron26@gmail.com -->