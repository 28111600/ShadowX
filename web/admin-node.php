<?php
require_once '../template/main.php';
require_once '../lib/admin-check.php';
require_once '../template/head.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>节点列表
            <small>Node List</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <a class="btn btn-success" href="admin-node-detail.php?id=new">添加节点</a>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="location.reload();">刷新</button>
                </div>
            </div>
        </div>
        <div class="row">
        <?php
        $nodes = ShadowX\Node::getAllNodes();
        foreach ($nodes as $row) { ?>
            <div class="col-md-6">
                <div class="nav-tabs-custom box box-primary">
                    <ul class="nav nav-tabs pull-right">
                        <li><a class="option text-blue" href="admin-node-detail.php?id=<?php echo $row['id']; ?>">编辑</a></li>
                        <!--<li><a class="option text-red node-delete" data-id="<?php echo $row['id']; ?>" href="#">删除</a></li>-->
                        <li class="pull-left header"><?php echo $row['name']; ?></li>
                    </ul>
                    <div class="tab-content">
                        <table class="table"> 
                            <thead>
                                <tr><td>节点地址</td> <td class="text-right"><?php echo $row['server']; ?></td></tr>
                            </thead>
                            <tbody>
                                <tr><td>加密方式</td> <td class="text-right"><?php echo $row['method']; ?></td></tr>
                                <tr><td>说明</td> <td class="text-right"><?php echo $row['info']; ?></td></tr>
                                <tr><td>Uptime</td> <td class="text-right"><?php echo ShadowX\Utility::getUptime($row['uptime']); ?></td></tr>
                                <tr><td>负载</td> <td class="text-right"><?php echo $row['loadavg']; ?></td></tr>
                                <tr><td>刷新时间</td> <td class="text-right"><?php echo date('Y-m-d H:i:s', $row['checktime'] + $timeoffset); ?></td></tr>
                                <tr>
                                    <td>24小时流量</td>
                                    <td class="text-right"><div class="usage-box"><canvas data-id="<?php echo $row['node_id']; ?>" height="20px" width="144px" class="usage pull-right"></canvas></div></td>
                                </tr>
                            </tbody> 
                        </table>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
            <?php } ?>
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
    !(function() {
        var interval = 1200;
        var to = Math.floor(+new Date() / 1000 / interval ) * interval + getTimeZone() * 3600;
        var from = to - 3600 * 24;

        $(".usage").each(function() {
            var node_id = $(this).data("id");
            var elem = this;
            $.ajax({
                url: "ajax/admin-log.php",
                cache: false,
                type: "POST",
                data: {
                    action: "getLogRange",
                    from: from,
                    to: to,
                    type: "20min",
                    node_id: node_id
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showUsage(elem, from, to, interval, data.data);
            });
        });
    })();
</script>