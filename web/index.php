<?php
require_once '../template/main.php';
require_once '../template/head.php';

$used = round($User->getTransfer()/$User->getTransferEnable(), 2) * 100;
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
                                    <td><canvas height="25" width="180" class="usage" data-value="[{&quot;t&quot;:&quot;1504281600&quot;,&quot;u&quot;:&quot;557&quot;,&quot;d&quot;:&quot;0&quot;},{&quot;t&quot;:&quot;1504294800&quot;,&quot;u&quot;:&quot;23286&quot;,&quot;d&quot;:&quot;52411&quot;},{&quot;t&quot;:&quot;1504294800&quot;,&quot;u&quot;:&quot;45249&quot;,&quot;d&quot;:&quot;135854&quot;},{&quot;t&quot;:&quot;1504294800&quot;,&quot;u&quot;:&quot;9332&quot;,&quot;d&quot;:&quot;2844&quot;},{&quot;t&quot;:&quot;1504294800&quot;,&quot;u&quot;:&quot;0&quot;,&quot;d&quot;:&quot;77&quot;},{&quot;t&quot;:&quot;1504294800&quot;,&quot;u&quot;:&quot;17524&quot;,&quot;d&quot;:&quot;2421&quot;},{&quot;t&quot;:&quot;1504294800&quot;,&quot;u&quot;:&quot;16250&quot;,&quot;d&quot;:&quot;71124&quot;},{&quot;t&quot;:&quot;1504294800&quot;,&quot;u&quot;:&quot;3854&quot;,&quot;d&quot;:&quot;10323&quot;},{&quot;t&quot;:&quot;1504296000&quot;,&quot;u&quot;:&quot;9249&quot;,&quot;d&quot;:&quot;1413&quot;},{&quot;t&quot;:&quot;1504296000&quot;,&quot;u&quot;:&quot;229&quot;,&quot;d&quot;:&quot;525&quot;},{&quot;t&quot;:&quot;1504296000&quot;,&quot;u&quot;:&quot;18371&quot;,&quot;d&quot;:&quot;96594&quot;},{&quot;t&quot;:&quot;1504296000&quot;,&quot;u&quot;:&quot;2092&quot;,&quot;d&quot;:&quot;604&quot;},{&quot;t&quot;:&quot;1504296000&quot;,&quot;u&quot;:&quot;10134&quot;,&quot;d&quot;:&quot;2623&quot;},{&quot;t&quot;:&quot;1504296000&quot;,&quot;u&quot;:&quot;8286&quot;,&quot;d&quot;:&quot;1129&quot;},{&quot;t&quot;:&quot;1504297200&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504297200&quot;,&quot;u&quot;:&quot;1972&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504297200&quot;,&quot;u&quot;:&quot;17562&quot;,&quot;d&quot;:&quot;3524&quot;},{&quot;t&quot;:&quot;1504298400&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504298400&quot;,&quot;u&quot;:&quot;1972&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504298400&quot;,&quot;u&quot;:&quot;686&quot;,&quot;d&quot;:&quot;5004&quot;},{&quot;t&quot;:&quot;1504298400&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504299600&quot;,&quot;u&quot;:&quot;1700&quot;,&quot;d&quot;:&quot;4984&quot;},{&quot;t&quot;:&quot;1504299600&quot;,&quot;u&quot;:&quot;1068&quot;,&quot;d&quot;:&quot;1027&quot;},{&quot;t&quot;:&quot;1504299600&quot;,&quot;u&quot;:&quot;2284&quot;,&quot;d&quot;:&quot;6754&quot;},{&quot;t&quot;:&quot;1504299600&quot;,&quot;u&quot;:&quot;888&quot;,&quot;d&quot;:&quot;6665&quot;},{&quot;t&quot;:&quot;1504300800&quot;,&quot;u&quot;:&quot;1972&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504300800&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504302000&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504302000&quot;,&quot;u&quot;:&quot;1972&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504302000&quot;,&quot;u&quot;:&quot;686&quot;,&quot;d&quot;:&quot;5005&quot;},{&quot;t&quot;:&quot;1504303200&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504303200&quot;,&quot;u&quot;:&quot;1565&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504303200&quot;,&quot;u&quot;:&quot;713&quot;,&quot;d&quot;:&quot;157&quot;},{&quot;t&quot;:&quot;1504303200&quot;,&quot;u&quot;:&quot;1027&quot;,&quot;d&quot;:&quot;157&quot;},{&quot;t&quot;:&quot;1504303200&quot;,&quot;u&quot;:&quot;709&quot;,&quot;d&quot;:&quot;157&quot;},{&quot;t&quot;:&quot;1504303200&quot;,&quot;u&quot;:&quot;709&quot;,&quot;d&quot;:&quot;157&quot;},{&quot;t&quot;:&quot;1504303200&quot;,&quot;u&quot;:&quot;709&quot;,&quot;d&quot;:&quot;195&quot;},{&quot;t&quot;:&quot;1504303200&quot;,&quot;u&quot;:&quot;709&quot;,&quot;d&quot;:&quot;157&quot;},{&quot;t&quot;:&quot;1504303200&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504304400&quot;,&quot;u&quot;:&quot;796&quot;,&quot;d&quot;:&quot;5712&quot;},{&quot;t&quot;:&quot;1504304400&quot;,&quot;u&quot;:&quot;2007&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504304400&quot;,&quot;u&quot;:&quot;713&quot;,&quot;d&quot;:&quot;157&quot;},{&quot;t&quot;:&quot;1504304400&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504305600&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504305600&quot;,&quot;u&quot;:&quot;2007&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504305600&quot;,&quot;u&quot;:&quot;1693&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504306800&quot;,&quot;u&quot;:&quot;686&quot;,&quot;d&quot;:&quot;5004&quot;},{&quot;t&quot;:&quot;1504306800&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504306800&quot;,&quot;u&quot;:&quot;2007&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504306800&quot;,&quot;u&quot;:&quot;12126&quot;,&quot;d&quot;:&quot;3444&quot;},{&quot;t&quot;:&quot;1504306800&quot;,&quot;u&quot;:&quot;858&quot;,&quot;d&quot;:&quot;94194&quot;},{&quot;t&quot;:&quot;1504308000&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504308000&quot;,&quot;u&quot;:&quot;19250&quot;,&quot;d&quot;:&quot;8540&quot;},{&quot;t&quot;:&quot;1504308000&quot;,&quot;u&quot;:&quot;9700&quot;,&quot;d&quot;:&quot;6091&quot;},{&quot;t&quot;:&quot;1504308000&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504308000&quot;,&quot;u&quot;:&quot;1068&quot;,&quot;d&quot;:&quot;1180&quot;},{&quot;t&quot;:&quot;1504309200&quot;,&quot;u&quot;:&quot;1693&quot;,&quot;d&quot;:&quot;421&quot;},{&quot;t&quot;:&quot;1504309200&quot;,&quot;u&quot;:&quot;975&quot;,&quot;d&quot;:&quot;447&quot;},{&quot;t&quot;:&quot;1504309200&quot;,&quot;u&quot;:&quot;2007&quot;,&quot;d&quot;:&quot;785&quot;},{&quot;t&quot;:&quot;1504309200&quot;,&quot;u&quot;:&quot;19387&quot;,&quot;d&quot;:&quot;4465&quot;},{&quot;t&quot;:&quot;1504309200&quot;,&quot;u&quot;:&quot;16527&quot;,&quot;d&quot;:&quot;1810&quot;},{&quot;t&quot;:&quot;1504310400&quot;,&quot;u&quot;:&quot;9269&quot;,&quot;d&quot;:&quot;1456&quot;},{&quot;t&quot;:&quot;1504310400&quot;,&quot;u&quot;:&quot;686&quot;,&quot;d&quot;:&quot;5006&quot;},{&quot;t&quot;:&quot;1504310400&quot;,&quot;u&quot;:&quot;2982&quot;,&quot;d&quot;:&quot;868&quot;}]"
                                            style="display: block; height: 20px; width: 144px;"></canvas></td>
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
        var from = 1504225200;
        var to = 1504311600;
        showUsage(".usage", from, to, 1200);
    })();
</script>