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
                    <button type="button" id="addInviteCode" <?php echo $User->getInviteNum() == 0 ? 'disabled="disabled"' : ''; ?> class="btn btn-success">生成邀请码</button>
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
                                    <th>#</th>
                                    <th>邀请码</th>
                                    <th>状态</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $index = 1;
                            $invite = new ShadowX\Invite($User->getUid());
                            $codes = $invite->getInviteCodes();
                            foreach ($codes as $row) { ?>
                                <tr>
                                    <td><?php echo $index; $index++; ?></td>
                                    <td><?php echo $row['code']; ?></td>
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