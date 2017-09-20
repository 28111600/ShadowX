<?php
$page_title = "系统信息";
require_once '../template/main.php';
require_once '../lib/admin-check.php';
require_once '../template/head.php';
?>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                 <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">流量图表 - 30 Days</h4>
                    </div>
                    <div class="card-content">
                        <div class="usage-box"><canvas width="16px" height="9px" class="usage-month"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                 <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">流量图表 - 24 Hours</h4>
                    </div>
                    <div class="card-content">
                        <div class="usage-box"><canvas width="16px" height="9px" class="usage-day"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-header" data-background-color>
                        <h4 class="title">流量使用情况</h4>
                    </div>
                    <div class="card-content">
                        <table class="table">
                            <tbody>
                                <tr><td>版本</td><td class="text-right"><?php echo $version; ?></td></tr>
                                <tr><td>当前时间</td><td class="text-right"><?php echo date("Y-m-d H:i",time() + $timeoffset); ?></td></tr>
                                <tr>
                                    <td>30天流量</td>
                                    <td><div class="usage-box pull-right"><canvas height="20px" width="144px" class="usage"></canvas></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../template/footer.php'; ?>

<!-- Chart 2.6.0 -->
<script src="asset/js/Chart.bundle.min.js"></script>

<script>
    !(function() {
        var interval = 3600 * 24;
        var to = getTimePoint(new Date(), interval);
        var from = to - 3600 * 24 * 30;

        $(".usage").each(function() {
            var elem = this;
            $.ajax({
                url: "ajax/admin-log.php",
                cache: false,
                type: "POST",
                data: {
                    action: "getLogRange",
                    from: from,
                    to: to + interval - 1,
                    type: "days"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showUsage(elem, from, to, interval, data.data);
            });
        });
    })();

    !(function() {
        var interval = 3600 * 24;
        var to = getTimePoint(new Date(), interval);
        var from = to - 3600 * 24 * 30;

        $(".usage-month").each(function() {
            var elem = this;
            $.ajax({
                url: "ajax/admin-log.php",
                cache: false,
                type: "POST",
                data: {
                    action: "getLogRange",
                    from: from,
                    to: to + interval - 1,
                    type: "days"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showChart(elem, from, to, interval, data.data);
            });
        });
    })();

    !(function() {
        var interval = 1200;
        var to = getTimePoint(new Date(), interval);
        var from = to - 3600 * 24;

        $(".usage-day").each(function() {
            var elem = this;
            $.ajax({
                url: "ajax/admin-log.php",
                cache: false,
                type: "POST",
                data: {
                    action: "getLogRange",
                    from: from,
                    to: to + interval - 1,
                    type: "20min"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showChart(elem, from, to, interval, data.data);
            });
        });
    })();
</script>