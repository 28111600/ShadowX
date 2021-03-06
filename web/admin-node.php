<?php
$page_title = "节点列表";
require_once '../template/main.php';
require_once '../lib/admin-check.php';
require_once '../template/head.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
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
        if (count($nodes) > 0) {
            foreach ($nodes as $row) { ?>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header" data-background-color>
                        <a class="option pull-right" href="admin-node-detail.php?id=<?php echo $row['id']; ?>">详情</a>
                        <h4 class="title"><?php echo $row['name']; ?></h4>
                    </div>
                    <div class="card-content">
                        <table class="table">
                            <tbody>
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
                </div>
            </div><?php }
            } else { ?>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header" data-background-color>
                        <h4 class="title">无可用节点</h4>
                    </div>
                    <div class="card-content">
                        <p>点击<strong>添加节点</strong>按钮添加新节点</p>
                    </div>
                </div>
            </div><?php } ?>
        </div>
    </div>
</div>

<?php
require_once '../template/footer.php'; ?>

<!-- Chart 2.6.0 -->
<script src="asset/js/Chart.bundle.min.js"></script>

<script>
    !(function() {
        var interval = 1200;
        var to = getTimePoint(new Date(), interval);
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
                    to: to + interval - 1,
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