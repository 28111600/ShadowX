<?php
require_once '../template/main.php';
require_once '../template/head.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>邀请好友
            <small>Invite Friends</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <div class="btn-group">
                    <button type="button" id="user-addinvitecode" <?php echo $User->getInviteNum() == 0 ? 'disabled="disabled"' : ''; ?> class="btn btn-success">生成邀请码</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="callout callout-info">
                    <p>可生成数量：<?php echo $User->getInviteNum(); ?></p>
                </div>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">邀请码</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>邀请码</th>
                                    <th>状态</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $invite = new ShadowX\Invite($User->getUid());
                            $codes = $invite->getInviteCodes();
                            foreach ($codes as $row) { ?>
                                <tr>
                                    <td><code class="<?php echo $row['status'] != 1 ? 'delete-line' : ''; ?>"><?php echo $row['code']; ?></code></td>
                                    <td>
                                        <?php
                                            if ($row['status'] == 1) {
                                                echo "可用";
                                            } else {
                                                echo "已用";
                                                if (!empty($row['used_uid'])) {
                                                    $used_user = new ShadowX\User($row['used_uid']);
                                                    if ($used_user->isExists()) {
                                                        echo " / ".$used_user->getUserName();
                                                    }
                                                }
                                        } ?>
                                     </td>
                                </tr>
                            <?php } ?>
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

<script>
    !(function() {
        function addInviteCode() {
            $.ajax({
                type: "POST",
                url: "ajax/user.php",
                dataType: "json",
                data: {
                    action: "addinvitecode"
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("操作成功", "success", 1000);
                        setTimeout(function() { location.href = "invite.php"; }, 1000);
                    } else {
                        new Message(data.msg, "error", 1000);
                        $("#user-addinvitecode").attr("disabled", false);
                    }
                },
                error: function(jqXHR) {
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                    $("#user-addinvitecode").attr("disabled", false);
                }
            });
        }

        $("#user-addinvitecode").click(function() {
            $("#user-addinvitecode").attr("disabled", true);
            addInviteCode();
            return false;
        });
    })();
</script>