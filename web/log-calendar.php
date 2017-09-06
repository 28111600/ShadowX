<?php
require_once '../template/main.php';
require_once '../template/head.php';

$url_log = 'log.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>流量日志 - 日历视图
            <small>Traffic Log - Calendar</small>
        </h1>
    </section>
    <?php require_once '../template/log-calendar.php'; ?>
</div>
<!-- /.content-wrapper -->
<?php
require_once '../template/footer.php'; ?>

<!-- Moment 2.18.1 -->
<script src="asset/js/moment.min.js"></script>
<!-- FullCalendar 3.5.0 -->
<link rel="stylesheet" href="asset/css/fullcalendar.min.css">
<script src="asset/js/fullcalendar.min.js"></script>

<script>
    (function() {
        /* initialize the calendar */
        var eventsCache = {};
        $('#calendar').fullCalendar({
            theme: 'bootstrap3',
            header: {
                right: 'prev,next today',
                left: 'title',
                center: ''//'month,agendaWeek,agendaDay'
            },
            views: {
                month: {
                    titleFormat: 'YYYY/MM'
                }
            },
            buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },
            events: function(from, to, timezone, callback) {
                var cacheKey = from.unix() + "-" + to.unix();
                var cache = eventsCache[cacheKey];
                if (cache) {
                    callback(cache);
                } else {
                    $.ajax({
                        url: "ajax/log.php",
                        cache: false,
                        type: "POST",
                        data: {
                            action: "getLogRange",
                            from: from.unix(),
                            to: to.unix(),
                            type: "days"
                        }
                    }).done(function(text) {
                        var data = JSON.parse(text);
                        var events = [];
                        $.each(data.data, function(index, item){
                            var t = moment(parseInt(item.t) * 1000).format('YYYY-MM-DD');
                            parseInt(item.u) && events.push({
                                title: '↑ ' + getSize(item.u, 2),
                                start: t,
                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                borderColor: 'rgba(54, 162, 235, 1)'
                            });
                            parseInt(item.d) && events.push({
                                title: '↓ ' + getSize(item.d, 2),
                                start: t,
                                backgroundColor: 'rgba(0, 166, 90, 0.7)',
                                borderColor: 'rgba(0, 166, 90, 1)'
                            });
                        });
                        eventsCache[cacheKey] = events;
                        callback(events);
                    });
                }
            },
            editable: false,
            droppable: false
        });
    })();
</script>
