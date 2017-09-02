<?php
require_once '../template/main.php';
require_once '../lib/admin-check.php';
require_once '../template/head.php';

$node = new ShadowX\Node();

$Log = new ShadowX\Log();
$interval = 1200;
$to = strtotime(date("Y-m-d H:i", floor((time() + $timeoffset) / $interval) * $interval).":00");
$from = $to - 3600 * 24;
$logs = $Log->getLogsRange($from, $to, '20min', '', $timeoffset);
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
                    <button type="button" class="btn btn-primary">添加节点</button>
                </div>
            </div>
        </div>
        <div class="row">
        <?php
        $nodes = $node->getAllNodes();
        foreach($nodes as $row){ ?>
            <div class="col-md-6">
                <div class="nav-tabs-custom box box-primary">
                    <ul class="nav nav-tabs pull-right">
                        <li><a class="option text-blue " href="#">编辑</a></li>
                        <li><a class="option text-red node-delete" data-id="<?php echo $row['id']; ?>" href="#">删除</a></li>
                        <li class="pull-left header"><?php echo $row['name']; ?></li>
                    </ul>
                    <div class="tab-content">
                        <table class="table"> 
                            <thead>
                                <tr><td>节点地址</td> <td class="text-right"><?php echo $row['server']; ?></td></tr>
                            </thead>
                            <tbody>
                                <tr><td>状态</td> <td class="text-right"><?php echo $row['status']; ?></td></tr>
                                <tr><td>加密方式</td> <td class="text-right"><?php echo $row['method']; ?></td></tr>
                                <tr><td>说明</td> <td class="text-right"><?php echo $row['info']; ?></td></tr>
                                <tr><td>Uptime</td> <td class="text-right"><?php echo ShadowX\Utility::getUptime($row['uptime']); ?></td></tr>
                                <tr><td>负载</td> <td class="text-right"><?php echo $row['loadavg']; ?></td></tr>
                                <tr><td>刷新时间</td> <td class="text-right"><?php echo date('Y-m-d H:i:s', $row['checktime'] + $timeoffset); ?></td></tr>
                                <tr>
                                    <td>24小时流量</td>
                                    <td class="text-right"><canvas height="20px" width="144px" class="usage pull-right" data-value='<?php $rows = array(); foreach ($logs as $log) { $d['t'] = $log['t']; $d['u'] = $log['u']; $d['d'] = $log['d']; $rows[] = $d; }; echo json_encode($rows); ?>'></canvas></td>
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
        var from = <?php echo $from; ?>;
        var to = <?php echo $to; ?>;
        var interval =  <?php echo $interval; ?>;
        showUsage(".usage", from, to, interval);
    })();
    !(function() {
        $(".node-delete").click(function(){
            if (confirm("确认删除此节点？")) {
                var id = $(this).data("id");
                $.ajax({
                    type:"POST",
                    url:"ajax/node.php",
                    dataType:"json",
                    data:{
                        action: "delete",
                        id: id
                    },
                    success:function(data){
                        if(data.ok){
                            new Message("操作成功！", "success");
                            setTimeout(function(){ location.reload(); }, 1000);
                        }else{
                            new Message("操作失败！", "error");
                            setTimeout(function(){ location.reload(); }, 1000);
                        }
                    },
                    error:function(jqXHR){
                        new Message("发生错误：" + jqXHR.status, "error", 1000);
                    }
                })
            }
            return false;
        })
    })();
</script>