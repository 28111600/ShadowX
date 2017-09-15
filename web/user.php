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
                    <div class="box-body">
                        <div class="form-group">
                            <label>用户名</label>
                            <span class="form-control"><?php echo $User->getUserName(); ?></span>
                        </div>
                        <div class="form-group">
                            <label>邮箱</label>
                            <span class="form-control"><?php echo $User->getEmail(); ?></span>
                        </div>
                        <div class="form-group">
                            <label>连接密码</label>
                            <span class="form-control"><?php echo $User->getSsPasswd(); ?></span>
                        </div>
                        <div class="form-group">
                            <label>流量</label>
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
                            <label>邀请人</label>
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
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">修改登录密码</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-passwd">
                        <div class="box-body">
                            <div class="form-group">
                                <label>密码</label>
                                <input class="form-control" id="passwd" type="password" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label>确认密码</label>
                                <input class="form-control" id="repasswd" type="password" autocomplete="new-password">
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" id="user-passwd" class="btn btn-success">保存</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">修改连接密码</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-sspasswd">
                        <div class="box-body">
                            <div class="form-group">
                                <label>密码</label>
                                <input class="form-control" id="sspasswd" autocomplete="new-password" placeholder="留空则自动生成">
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" id="user-sspasswd" class="btn btn-success">保存</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
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
    !(function() {
        function sspasswd() {
            $.ajax({
                type: "POST",
                url: "ajax/user.php",
                dataType: "json",
                data: {
                    action:"sspasswd",
                    passwd: encodeURIComponent($("#sspasswd").val()),
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("操作成功", "success", 1000);
                        setTimeout(function() { location.href = "user.php"; }, 1000);
                    } else {
                        $("#user-sspasswd").attr("disabled", false);
                        new Message(data.msg, "error", 1000);
                    }
                },
                error: function(jqXHR) {
                    $("#user-sspasswd").attr("disabled", false);
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                }
            });
        }
        $("#form-sspasswd").submit(function() {
            $("#user-sspasswd").attr("disabled", true);
            sspasswd();
            return false;
        });
    })();

    !(function() {
        function passwd() {
            $.ajax({
                type: "POST",
                url: "ajax/user.php",
                dataType: "json",
                data: {
                    action: "passwd",
                    passwd: $("#passwd").val(),
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("密码已重置，需重新登录", "success", 1000);
                        setTimeout(function() { location.href = "user.php"; }, 1000);
                    } else {
                        $("#resetpwd").attr("disabled", false);
                        new Message(data.msg, "error", 1000);
                    }
                },
                error: function(jqXHR) {
                    $("#resetpwd").attr("disabled", false);
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                }
            });
        }
        $("#form-passwd").submit(function() {
            if ($("#passwd").val() !== $("#repasswd").val()) {
                new Message("两次填写的密码不一致", "error", 1000);
            } else {
                $("#resetpwd").attr("disabled", true);
                passwd();
            }
            return false;
        });
    })();

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