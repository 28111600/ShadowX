<?php
require_once '../template/main.php';
require_once '../template/head.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>用户详情
            <small>User Profile</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">用户详情</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cate_title">用户名</label>
                                <span class="form-control"><?php echo $User->getUserName(); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">邮箱</label>
                                <span class="form-control"><?php echo $User->getEmail(); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">连接密码</label>
                                <span class="form-control"><?php echo $User->getSsPasswd(); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">流量</label>
                                <span class="form-control"><?php echo ShadowX\Utility::getSize($User->getTransferEnable()); ?></span>
                            </div>
                            <div class="form-group">
                                <div class="progress-usage">
                                    <div class="progress" data-toggle="tooltip" title='<?php echo ShadowX\Utility::getSize($User->getUnusedTransfer()); ?> / <?php echo ShadowX\Utility::getSize($User->getTransfer()); ?> / <?php echo ShadowX\Utility::getSize($User->getTransferEnable()); ?>'>
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo min(max(($User->getTransfer()) * 100 / $User->getTransferEnable(), 0), 100); ?>%"> <span class="sr-only">Transfer</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">邀请人</label>
                                <span class="form-control"><?php
                                    if (!empty($User->getRefBy())) {
                                        $used_user = new ShadowX\User($User->getRefBy());
                                        if ($used_user->isExists()) {
                                            echo $used_user->getUserName();
                                        } else {
                                            echo "未知";
                                        }
                                    } else {
                                        echo "无";
                                    }
                                ?></span>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">流量图表 - 30 Days</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="usage-box"><canvas width="16px" height="9px" class="usage-month"></canvas></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">流量图表 - 24 Hours</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="usage-box"><canvas width="16px" height="9px" class="usage-day"></canvas></div>
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

<!-- Select2 4.0.3 -->
<script src="asset/js/select2.min.js"></script>
<!-- Chart 2.6.0 -->
<script src="asset/js/Chart.bundle.min.js"></script>

<script>
    var uid = <?php echo $User->getUid(); ?>;
    !(function() {
        var interval = 3600 * 24;
        var to = getTimePoint(new Date(), interval);
        var from = to - 3600 * 24 * 30;

        $(".usage-month").each(function() {
            var elem = this;
            $.ajax({
                url: "ajax/log.php",
                cache: false,
                type: "POST",
                data: {
                    action: "getLogRange",
                    from: from,
                    to: to + interval -1,
                    type: "days"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showChart(elem, from, to, interval, data.data);
            });
        });
    })();

    !(function() {
        var interval = 3600;
        var to = getTimePoint(new Date(), interval);
        var from = to - 3600 * 24;

        $(".usage-day").each(function() {
            var elem = this;
            $.ajax({
                url: "ajax/log.php",
                cache: false,
                type: "POST",
                data: {
                    action: "getLogRange",
                    from: from,
                    to: to + interval -1,
                    type: "hours"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showChart(elem, from, to, interval, data.data);
            });
        });
    })();
</script>