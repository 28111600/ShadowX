<?php
require_once '../template/main.php';
require_once '../template/head.php';

$used = round($User->getTransfer()/$User->getTransferEnable(), 2) * 100;

$Log = new ShadowX\Log($User->getUid());
$interval = 1200;
$to = strtotime(date("Y-m-d H:i", floor((time() + $timeoffset) / $interval) * $interval).":00");
$from = $to - 3600 * 24;
$logs = $Log->getLogsRange($from, $to, '20min', '', $timeoffset);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>用户中心
            <small>User Center</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">流量使用情况</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>已用流量</td>
                                    <td><?php echo \ShadowX\Utility::getSize($User->getTransfer()); ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>剩余流量</td>
                                    <td><?php echo \ShadowX\Utility::getSize($User->getUnusedTransfer()); ?></td>
                                </tr>
                                <tr>
                                    <td>总流量</td>
                                    <td><?php echo \ShadowX\Utility::getSize($User->getTransferEnable()); ?></td>
                                </tr>
                                <tr>
                                    <td>24小时流量</td>
                                    <td><canvas height="20px" width="144px" class="usage" data-value='<?php $rows = array(); foreach ($logs as $log) { $d['t'] = $log['t']; $d['u'] = $log['u']; $d['d'] = $log['d']; $rows[] = $d; }; echo json_encode($rows); ?>'></canvas></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="progress-group">
                                            <div class="progress sm" data-toggle="tooltip" data-placement="top" title='<?php echo $used; ?>%'>
                                                <div class="progress-bar progress-bar-primary" style="width: <?php echo $used; ?>%"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">连接信息</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>端口</td>
                                    <td><code><?php echo $User->getPort(); ?></code></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>密码</td>
                                    <td><code class="ss-pwd-toggle" data-value="<?php echo addslashes($User->getPass()); ?>">点击查看</code></td>
                                </tr>
                                <tr>
                                    <td>最后使用时间</td>
                                    <td><code><?php echo date('Y-m-d H:i:s',$User->getLastUseTime() + $timeoffset); ?></code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
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

<!-- Chart 2.6.0 -->
<script src="asset/js/Chart.bundle.min.js"></script>

<script>
    $(".ss-pwd-toggle").one("click", function() {
        var that = $(this);
        that.html(that.data("value")).removeClass("ss-pwd-toggle");
    });

    !(function() {
        var from = <?php echo $from; ?>;
        var to = <?php echo $to; ?>;
        var interval =  <?php echo $interval; ?>;
        showUsage(".usage", from, to, interval);
    })();
</script>