<?php
$page_title = "节点列表";
require_once '../template/main.php';
require_once '../template/head.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <?php 
        $nodes = ShadowX\Node::getAllNodes();
        if (count($nodes) > 0) {
            foreach ($nodes as $row) { ?>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header" data-background-color>
                        <a class="option pull-right" href="#" data-id="<?php echo $row['id']; ?>">配置</a>
                        <div class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><?php echo $row['name']; ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>节点地址</td>
                                                    <td class="text-left"><?php echo $row['server']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>配置地址</td>
                                                    <td class="text-left"><input readonly="readonly" class="option-url form-control"></td>
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
                                </div>
                            </div>
                        </div>
                        <h4 class="title"><?php echo $row['name']; ?></h4>
                    </div>
                    <div class="card-content">
                        <table class="table">
                            <tbody>
                                <tr><td>节点地址</td> <td class="text-right"><?php echo $row['server']; ?></td></tr>
                                <tr><td>加密方式</td> <td class="text-right"><?php echo $row['method']; ?></td></tr>
                                <tr><td>说明</td> <td class="text-right"><?php echo $row['info']; ?></td></tr>
                                <tr><td>Uptime</td> <td class="text-right"><?php echo ShadowX\Utility::getUptime($row['uptime']); ?></td></tr>
                                <tr><td>负载</td> <td class="text-right"><?php echo $row['loadavg']; ?></td></tr>
                                <tr><td>刷新时间</td> <td class="text-right"><?php echo date('Y-m-d H:i:s', $row['checktime'] + $timeoffset); ?></td></tr>
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
                        <p>暂无可用节点</p>
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
                height: 256,
                width: 256
            });
            that.parent().find(".option-url").val(ssurl_encode).focus(function() {
                this.select();
            });
            that.parent().find(".option-json").val(text).focus(function() {
                this.select();
            });
        });
    });
</script>