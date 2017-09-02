<?php
require_once '../template/main.php';
require_once '../template/head.php';

$Log = new ShadowX\Log($User->getUid());
$to = strtotime(date("Y-m-d 00:00:00", time() + $timeoffset));
$from = strtotime(date("Y-m-1 00:00:00", time() + $timeoffset));
$logs = $Log->getLogsRange($from, $to, 'days', '', $timeoffset);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>流量日志 - 日历视图
            <small>Traffic Log - Calendar</small>
        </h1>
    </section>
    <!-- Main content -->
     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12 col-lg-9">
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
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
        var data = <?php $rows = array(); foreach ($logs as $log) { $d['t'] = $log['t']; $d['u'] = $log['u']; $d['d'] = $log['d']; $rows[] = $d; }; echo json_encode($rows); ?>;
        var events = [];
        $.each(data, function(index, item){
            events.push({
                title: '↑ ' + getSize(item.u, 2),
                start: moment(parseInt(item.t * 1000)).format('YYYY-MM-DD'),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)'
            });
            events.push({
                title: '↓ ' + getSize(item.d, 2),
                start: moment(parseInt(item.t * 1000)).format('YYYY-MM-DD'),
                backgroundColor: 'rgba(0, 166, 90, 0.7)',
                borderColor: 'rgba(0, 166, 90, 1)'
            });
        })
        console.log(events);
        $('#calendar').fullCalendar({
            header: {
                right: '',//'prev,next today',
                left: 'title',
                center: ''//'month,agendaWeek,agendaDay'
            },
            views: {
                month: {
                    titleFormat: 'YYYY-MM'
                },
                week: {
                    titleFormat: 'YYYY-MM-DD'
                },
                day: {
                    titleFormat: 'YYYY-MM-DD'
                }
            },
            buttonText: {
                today: 'today',
                month: 'month',
                week: 'week',
                day: 'day'
            },
            events: events,
            editable: false,
            droppable: false
        })
    })();
</script>
