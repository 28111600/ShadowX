<?php
require_once '../template/main.php';
require_once '../lib/admin-check.php';
require_once '../template/head.php';

if(!empty($_GET)){
    $uid = $_GET['uid'];
    $isEdit = isset($_GET['edit']);
    $user = new ShadowX\User($uid);
    $rs = $user->getUser();
}
$gb = 1024 * 1024 * 1024;
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
                    <?php if ($isEdit) { ?>
                        <h3 class="box-title">编辑用户</h3>
                    <?php } else { ?>
                        <h3 class="box-title">用户详情</h3>
                    <?php } ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-user">
                        <div class="box-body">
                        <?php if ($isEdit) { ?>
                            <div class="form-group hidden">
                                <label>id</label>
                                <input class="form-control" id="uid" value="<?php echo $rs['uid']; ?>">
                            </div>
                            <div class="form-group">
                                <label>用户名</label>
                                <input class="form-control" id="name" required="required" value="<?php echo $rs['user_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label>邮箱</label>
                                <input class="form-control" id="email" required="required" value="<?php echo $rs['email']; ?>">
                            </div>
                            <div class="form-group">
                                <label>限速</label>
                                <div class="form-control">
                                    <input id="max-speed" type="text" value="<?php echo $rs['max_speed']; ?>">
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group">
                                <label>用户名</label>
                                <span class="form-control"><?php echo $rs['user_name']; ?></span>
                            </div>
                            <div class="form-group">
                                <label>邮箱</label>
                                <span class="form-control"><?php echo $rs['email']; ?></span>
                            </div>
                            <div class="form-group">
                                <label>可用邀请码</label>
                                <span class="form-control"><?php echo $rs['invite_num']; ?></span>
                            </div>
                            <div class="form-group">
                                <label>邀请人</label>
                                <span class="form-control"><?php
                                    if (!empty($rs['ref_by'])) {
                                        $used_user = new ShadowX\User($rs['ref_by']);
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
                            <div class="form-group">
                                <label>注册时间</label>
                                <span class="form-control"><?php echo date('Y-m-d H:i:s', $rs['reg_date'] + $timeoffset); ?></span>
                            </div>
                            <div class="form-group">
                                <label>注册IP</label>
                                <span class="form-control"><?php echo $rs['reg_ip']; ?></span>
                            </div>
                        <?php } ?>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                        <?php if ($isEdit) { ?>
                            <button type="submit" id="update" class="btn btn-success">保存</button>
                            <a href="?uid=<?php echo $rs['uid']; ?>" class="btn btn-default">取消</a>
                        <?php } else { ?>
                            <a href="?uid=<?php echo $rs['uid']; ?>&edit" class="btn btn-primary">编辑</a>
                        <?php } ?>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <?php if (!$isEdit) { ?>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">流量使用</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label>连接密码</label>
                            <span class="form-control"><?php echo $rs['passwd']; ?></span>
                        </div>
                        <div class="form-group">
                            <label>流量</label>
                            <span class="form-control"><?php echo ShadowX\Utility::getSize($rs['transfer_enable']); ?></span>
                        </div>
                        <div class="form-group">
                            <div class="progress-usage">
                                <div class="progress" data-toggle="tooltip" title='<?php echo ShadowX\Utility::getSize($rs['transfer_enable'] - ($rs['u'] + $rs['d'])); ?> / <?php echo ShadowX\Utility::getSize($rs['u'] + $rs['d']); ?> / <?php echo ShadowX\Utility::getSize($rs['transfer_enable']); ?>'>
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo min(max(($rs['u'] + $rs['d']) * 100 / $rs['transfer_enable'], 0), 100); ?>%"> <span class="sr-only">Transfer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>限速</label>
                            <span class="form-control" id="max-speed"><?php echo $rs['max_speed']; ?></span>
                        </div>
                        <div class="form-group">
                            <label>最后使用时间</label>
                            <span class="form-control"><?php echo date('Y-m-d H:i:s', $rs['t'] + $timeoffset); ?></span>
                        </div>
                    </div><!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <?php } ?>
        </div>
        <?php if (!$isEdit) { ?>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">添加流量</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-transfer">
                        <div class="box-body">
                            <div class="form-group">
                                <label>流量(GByte)</label>
                                <input class="form-control" id="transfer" required="required" placeholder="小于0则扣除流量">
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" id="user-addtransfer" class="btn btn-success">确定</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">添加邀请码</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-invitenum">
                        <div class="box-body">
                            <div class="form-group">
                                <label>数量</label>
                                <input class="form-control" id="invitenum" required="required" placeholder="小于0则减少邀请码数量">
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" id="user-addinvitenum" class="btn btn-success">确定</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
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
        <?php } ?>
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
<!-- Messg -->
<link rel="stylesheet" href="asset/css/bootstrap-slider.min.css">
<script src="asset/js/bootstrap-slider.min.js"></script>

<script>
    var speeds = [
        { value:  512, label: "512 Kbps" },
        { value: 1024, label: "1 Mbps" },
        { value: 2048, label: "2 Mbps" },
        { value: 4096, label: "4 Mbps" },
        { value: 8192, label: "8 Mbps" },
        { value:    0, label: "不限速" }
    ];

    function getSpeed(value) {
        var result = {};
        $.each(speeds, function(index, item){
            if (value === item.value) {
                result.index = index;
                result.value = item.value;
                result.label = item.label;
            }
        });
        return result;
    }
<?php if ($isEdit) { ?>
    !(function() {
        var max_speed = parseInt($("#max-speed").val());
        var speed = getSpeed(max_speed);
        $("#max-speed").slider({
            value: speed.index,
            ticks: [1, 2, 3, 4, 5, 0],
            formatter: function(value) {
                return speeds[value].label;
            }
        });
    })();

    var uid = <?php echo $rs['uid']; ?>;
    function update() {
        $.ajax({
            type: "POST",
            url: "ajax/admin-user.php",
            dataType: "json",
            data: {
                action: "update",
                uid: $("#uid").val(),
                username: $("#name").val(),
                email: $("#email").val(),
                max_speed: speeds[parseInt($("#max-speed").val())].value
            },
            success: function(data) {
                if (data.ok) {
                    new Message("操作成功", "success", 1000);
                    setTimeout(function() { location.href = "admin-user-detail.php?uid=" + uid; }, 1000);
                } else {
                    new Message("操作失败", "error", 1000);
                    $("#user-update").attr("disabled", false);
                }
            },
            error: function(jqXHR) {
                new Message("发生错误：" + jqXHR.status, "error", 1000);
                $("#user-update").attr("disabled", false);
            }
        });
    }

    $("#form-user").submit(function() {
        $("#user-update").attr("disabled", true);
        update();
        return false;
    });

<?php } else { ?>
    var uid = <?php echo $rs['uid']; ?>;

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
                    uid: uid,
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
                    uid: uid,
                    type: "20min"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showChart(elem, from, to, interval, data.data);
            });
        });
    })();

    !(function() {
        function addTransfer(transfer) {
            $.ajax({
                type: "POST",
                url: "ajax/admin-user.php",
                dataType: "json",
                data: {
                    action: "addtransfer",
                    uid: uid,
                    transfer: transfer * 1024 * 1024 * 1024
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("操作成功", "success", 1000);
                        setTimeout(function() { location.href = "admin-user-detail.php?uid=" + uid; }, 1000);
                    } else {
                        new Message(data.msg, "error", 1000);
                        $("#user-addtransfer").attr("disabled", false);
                    }
                },
                error: function(jqXHR) {
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                    $("#user-addtransfer").attr("disabled", false);
                }
            });
        }

        $("#form-transfer").submit(function() {
            var transfer = parseInt($("#transfer").val());
            if (transfer > 0 || transfer < 0) {
                $("#user-addtransfer").attr("disabled", true);
                addTransfer(transfer);
            }
            return false;
        });
    })();

    !(function() {
        function addInviteNum(num) {
            $.ajax({
                type: "POST",
                url: "ajax/admin-user.php",
                dataType: "json",
                data: {
                    action: "addinvitenum",
                    uid: uid,
                    num: num
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("操作成功", "success", 1000);
                        setTimeout(function() { location.href = "admin-user-detail.php?uid=" + uid; }, 1000);
                    } else {
                        new Message(data.msg, "error", 1000);
                        $("#user-addinvitenum").attr("disabled", false);
                    }
                },
                error: function(jqXHR) {
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                    $("#user-addinvitenum").attr("disabled", false);
                }
            });
        }

        $("#form-invitenum").submit(function() {
            var num = parseInt($("#invitenum").val());
            if (num > 0 || num < 0) {
                $("#user-addinvitenum").attr("disabled", true);
                addInviteNum(num);
            }
            return false;
        });

        !(function() {
            var speed = getSpeed(parseInt($("#max-speed").text()));
            $("#max-speed").text(speed.label);
        })();
    })();
<?php } ?>
</script>