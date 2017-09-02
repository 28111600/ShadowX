<?php
require_once '../template/main.php';
require_once '../template/head.php';

$node = new ShadowX\Node();
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
                    <button type="button" class="btn btn-primary" onclick="location.reload();">刷新</button>
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
                        <li class="dropdown">
                            <a class="option" href="#" data-id="<?php echo $row['id']; ?>">配置</a>
                            <div class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title"><?php echo $row['name']; ?></h4>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td>节点地址</td>
                                                        <td class="text-left"><?php echo $row['server']; ?></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>配置地址</td>
                                                        <td class="text-left"><input readonly="readonly" class="option-url form-control" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>配置Json</td>
                                                        <td class="text-left"><textarea readonly="readonly" rows="8" class="option-json form-control"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center" colspan="2"> <span class="option-qrcode"></span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
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
<!-- jQuery QRCode -->
<script src="asset/js/jquery.qrcode.min.js"></script>
<!-- jQuery Base64 -->
<script src="asset/js/jquery.base64.min.js"></script>

<script>
    $(".option").click(function() {
        var that = $(this);
        that.parent().find(".modal").modal();
        return false;
    });
    $(".option").each(function(index, item) {
        var that = $(item);
        var id = that.data("id");

        $.ajax({
            url: "ajax/node-url.php?id=" + id,
            cache: false
        }).done(function(text) {
            var data = JSON.parse(text);

            var ssurl = data.method + ":" + data.password + "@" + data.server + ":" + data.server_port;
            var ssurl_encode = "ss://" + $.base64.btoa(ssurl);
            that.parent().find(".option-qrcode").empty().qrcode({
                text: ssurl_encode,
                height: 128,
                width: 128
            });
            that.parent().find(".option-url").val(ssurl_encode).focus(function() {
                this.select();
            });
            var option = {
                server: data.server,
                server_port: data.server_port,
                password: data.password,
                method: data.method
            }

            that.parent().find(".option-json").val(text).focus(function() {
                this.select();
            });
        });
    });
</script>