<?php
require_once '../template/main.php';
require_once '../lib/admin-check.php';
require_once '../template/head.php';

$interval = 1200;
$to = strtotime(date("Y-m-d H:i", floor((time() + $timeoffset) / $interval) * $interval).":00");
$from = $to - 3600 * 24;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>用户列表
            <small>User List</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="location.reload();">刷新</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>邮箱</th>
                                    <th>端口</th>
                                    <th>流量</th>
                                    <th>24小时流量</th>
                                    <th>最后使用</th>
                                    <th>邀请人</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $users = $User->getAllUsers();
                            foreach ($users as $rs){ 
                                $Log = new ShadowX\Log($rs['uid']);
                                $logs = $Log->getLogsRange($from, $to, '20min', '', $timeoffset);?>
                                <tr>
                                    <td>#<?php echo $rs['uid']; ?></td>
                                    <td><?php echo $rs['user_name']; ?></td>
                                    <td><?php echo $rs['email']; ?></td>
                                    <td><?php echo $rs['port']; ?></td>
                                    <td>
                                        <div class="progress-usage">
                                            <div class="progress" data-toggle="tooltip" title='<?php echo ShadowX\Utility::getSize($rs['transfer_enable'] - ($rs['u'] + $rs['d'])); ?> / <?php echo ShadowX\Utility::getSize($rs['u'] + $rs['d']); ?> / <?php echo ShadowX\Utility::getSize($rs['transfer_enable']); ?>'>
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo min(max(($rs['u'] + $rs['d']) * 100 / $rs['transfer_enable'], 0), 100); ?>%"> <span class="sr-only">Transfer</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <canvas height="20px" width="144px" class="usage" data-value='<?php $rows = array(); foreach ($logs as $log) { $d['t'] = $log['t']; $d['u'] = $log['u']; $d['d'] = $log['d']; $rows[] = $d; }; echo json_encode($rows); ?>'></canvas>
                                        </div>
                                    </td>
                                    <td><?php echo date('Y-m-d H:i:s', $rs['t'] + $timeoffset); ?></td>
                                    <td>
                                        <?php
                                        if ($rs['ref_by'] != 0) {
                                            $user_ref = new ShadowX\User($rs['ref_by']);
                                            echo $user_ref->GetUserName();
                                        } else {
                                            echo '-';
                                        } ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="#">查看</a>
                                        <a class="btn btn-danger btn-sm user-delete" data-uid="<?php echo $rs['uid']; ?>" href="#">删除</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require_once '../template/footer.php'; ?>

<!-- Chart 2.6.0 -->
<script src="asset/js/Chart.bundle.min.js"></script>

<script>
    !(function() {
        var from = <?php echo $from; ?>;
        var to = <?php echo $to; ?>;
        var interval =  <?php echo $interval; ?>;
        showUsage(".usage", from, to, interval);
    })();
</script>