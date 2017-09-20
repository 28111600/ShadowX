<?php
$page_title = "用户中心";
require_once '../template/main.php';
require_once '../template/head.php';

$used = round($User->getTransfer()/$User->getTransferEnable(), 2) * 100;
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-header" data-background-color>
                        <h4 class="title">流量使用情况</h4>
                    </div>
                    <div class="card-content">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>已用流量</td>
                                    <td><?php echo ShadowX\Utility::getSize($User->getTransfer()); ?></td>
                                </tr>
                                <tr>
                                    <td>剩余流量</td>
                                    <td><?php echo ShadowX\Utility::getSize($User->getUnusedTransfer()); ?></td>
                                </tr>
                                <tr>
                                    <td>总流量</td>
                                    <td><?php echo ShadowX\Utility::getSize($User->getTransferEnable()); ?></td>
                                </tr>
                                <tr>
                                    <td>24小时流量</td>
                                    <td><div class="usage-box"><canvas height="20px" width="144px" class="usage"></canvas></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="progress" data-toggle="tooltip" data-placement="top" title='<?php echo $used; ?>%'>
                                            <div class="progress-bar progress-bar-info" style="width: <?php echo $used; ?>%"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-header" data-background-color>
                        <h4 class="title">连接信息</h4>
                    </div>
                    <div class="card-content">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td>端口</td>
                                    <td><code><?php echo $User->getPort(); ?></code></td>
                                </tr>
                                <tr>
                                    <td>密码</td>
                                    <td><code class="ss-pwd-toggle" data-value="<?php echo addslashes($User->getSsPasswd()); ?>">点击查看</code></td>
                                </tr>
                                <tr>
                                    <td>最后使用时间</td>
                                    <td><code><?php echo date('Y-m-d H:i:s', $User->getLastUseTime() + $timeoffset); ?></code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../template/footer.php'; ?>

<!-- Chart 2.6.0 -->
<script src="asset/js/Chart.bundle.min.js"></script>

<script>
    $(".ss-pwd-toggle").one("click", function() {
        var that = $(this);
        that.html(that.data("value")).removeClass("ss-pwd-toggle");
    });

    !(function() {
        var interval = 1200;
        var to = getTimePoint(new Date(), interval);
        var from = to - 3600 * 24;

        $(".usage").each(function() {
            var elem = this;
            $.ajax({
                url: "ajax/log.php",
                cache: false,
                type: "POST",
                data: {
                    action: "getLogRange",
                    from: from,
                    to: to + interval - 1,
                    type: "20min"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showUsage(elem, from, to, interval, data.data);
            });
        });
    })();
</script>