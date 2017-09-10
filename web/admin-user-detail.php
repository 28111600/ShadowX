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
                    <form role="form">
                        <div class="box-body">
                        <?php if ($isEdit) { ?>
                            <div class="form-group hidden">
                                <label for="cate_title">id</label>
                                <input class="form-control" id="uid" value="<?php echo $rs['uid']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="cate_title">用户名</label>
                                <input class="form-control" id="name" required="required" value="<?php echo $rs['user_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="cate_title">邮箱</label>
                                <input class="form-control" id="server" required="required" value="<?php echo $rs['email']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="cate_title">连接密码</label>
                                <input class="form-control" id="passwd" placeholder="留空则自动生成" value="<?php echo $rs['passwd']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="cate_title">限速(Kbps)</label>
                                <input class="form-control" id="passwd" placeholder="0则不限速" value="<?php echo $rs['max_speed']; ?>">
                            </div>
                        <?php } else { ?>
                            <div class="form-group">
                                <label for="cate_title">用户名</label>
                                <span class="form-control"><?php echo $rs['user_name']; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">邮箱</label>
                                <span class="form-control"><?php echo $rs['email']; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">连接密码</label>
                                <span class="form-control"><?php echo $rs['passwd']; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">流量</label>
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
                                <label for="cate_title">限速</label>
                                <span class="form-control"><?php echo $rs['max_speed'] == 0 ? "不限速" : $rs['max_speed']." Kbps"; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">最后使用时间</label>
                                <span class="form-control"><?php echo date('Y-m-d H:i:s', $rs['t'] + $timeoffset); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">可用邀请码</label>
                                <span class="form-control"><?php echo $rs['invite_num']; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">邀请人</label>
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
                                <label for="cate_title">注册时间</label>
                                <span class="form-control"><?php echo date('Y-m-d H:i:s', $rs['reg_date'] + $timeoffset); ?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">注册IP</label>
                                <span class="form-control"><?php echo $rs['reg_ip']; ?></span>
                            </div>
                        <?php } ?>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                        <?php if ($isEdit) { ?>
                            <button type="submit" class="btn btn-success">保存</button>
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
            <?php } ?>
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
<?php if ($isEdit) { ?>
    var uid = <?php echo $rs['uid']; ?>;
    function update() {
        $.ajax({
            type: "POST",
            url: "ajax/admin-user.php",
            dataType: "json",
            data: {
                action: "update",
                uid: $("#uid").val(),
                user_name: $("#name").val(),
                email: $("#email").val()
            },
            success: function(data) {
                if (data.ok) {
                    new Message("操作成功", "success", 1000);
                    setTimeout(function() { location.href = "admin-user-detail.php?uid=" + uid; }, 1000);
                } else {
                    new Message("操作失败", "error", 1000);
                }
            },
            error: function(jqXHR) {
                new Message("发生错误：" + jqXHR.status, "error", 1000);
            }
        });
    }

    $("form").submit(function() {
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
                    to: to + interval -1,
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
        var interval = 3600;
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
                    to: to + interval -1,
                    uid: uid,
                    type: "hours"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showChart(elem, from, to, interval, data.data);
            });
        });
    })();
<?php } ?>
</script>