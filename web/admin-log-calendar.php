<?php
require_once '../template/main.php';
require_once '../lib/admin-check.php';
require_once '../template/head.php';

$url_log = 'admin-log.php';
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

<!-- FullCalendar 3.5.0 -->
<script src="asset/js/fullcalendar.min.js"></script>

<script>
   !(function() {
        /* initialize the calendar */
        var eventsCache = {};
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                right: 'title',
                center: ''//'month,agendaWeek,agendaDay'
            },
            views: {
                month: {
                    titleFormat: 'YYYY/MM'
                },
                week: {
                    titleFormat: 'YYYY/MM/DD'
                },
                day: {
                    titleFormat: 'YYYY/MM/DD'
                }
            },
            buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },
            events: function(from, to, timezone, callback) {
                var cache = eventsCache[from.unix() + "-" + to.unix()];
                if (cache) {
                    callback(cache);
                } else {
                    $.ajax({
                        url: "ajax/admin-log.php",
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
                                borderColor: 'rgba(0, 0, 0, 0)'

                            });
                            parseInt(item.d) && events.push({
                                title: '↓ ' + getSize(item.d, 2),
                                start: t,
                                backgroundColor: 'rgba(0, 166, 90, 0.7)',
                                borderColor: 'rgba(0, 0, 0, 0)'
                            });
                        });
                        eventsCache[from.unix() + "-" + to.unix()] = events;
                        callback(events);
                    });
                }
            },
            editable: false,
            droppable: false,
            handleWindowResize: true
        })
    })();
</script>
