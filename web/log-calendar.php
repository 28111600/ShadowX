<?php
require_once '../template/main.php';
require_once '../template/head.php';

$url_log = 'log.php';

date_default_timezone_set('UTC');

$Log = new ShadowX\Log($User->getUid());
$t = isset($_GET['t']) ? strtotime($_GET['t']) : time();;
$from = strtotime(date("Y-m-d", mktime(0, 0, 0, date("m", $t), 1, date("Y", $t))));
$to = strtotime(date("Y-m-d", mktime(0, 0, 0, date("m", $t), date("t", $t), date("Y", $t))));
$logs = $Log->getLogsRange($from, $to, 'days', '', $timeoffset);

$t_pre = date("Y/m", mktime(0, 0, 0, date("m", $from - 3600), 1, date("Y", $from - 3600)));
$t_next = date("Y/m", mktime(0, 0, 0, date("m", $to + 3600 * 24), 1, date("Y", $to + 3600 * 24)));
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
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="btn-group">
                    <a class="btn btn-default" href="?t=<?php echo $t_pre; ?>"><i class="fa fa-angle-left" aria-hidden="true"></i> <?php echo $t_pre; ?></a>
                    <a class="btn btn-default" href="?t=<?php echo $t_next; ?>"><?php echo $t_next; ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
                
<?php
    if ($url_log) { ?>
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo $url_log; ?>">返回流量日志</a>
                </div>
<?php } ?>
            </div>
        </div>
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
            var t = moment(parseInt(item.t) * 1000).format('YYYY/MM/DD');
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
            console.log(t);
            console.log(item.t);
        })
        $('#calendar').fullCalendar({
            defaultDate: <?php echo $from; ?> * 1000,
            header: {
                right: '',//'prev,next today',
                left: 'title',
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
            events: events,
            editable: false,
            droppable: false
        })
    })();
</script>
