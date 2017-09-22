<?php
$page_title = "节点详情";
require_once '../template/main.php';
require_once '../lib/admin-check.php';
require_once '../template/head.php';

if(!empty($_GET)){
    $id = $_GET['id'];
    $isEdit = isset($_GET['edit']);
    if ($id === "new") {
        $isNew = true;
        $rs["id"] = "";
        $rs["node_id"] = "";
        $rs["name"] = "";
        $rs["server"] = "";
        $rs["method"] = "aes-256-cfb";
        $rs["info"] = "";
    } else {
        $isNew = false;
        $node = new ShadowX\Node($id);
        $rs = $node->getNode();
    }
}
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header" data-background-color>
                    <?php if ($isNew) { ?>
                        <h4 class="title">添加节点</h4>
                    <?php } else if ($isEdit) { ?>
                        <h4 class="title">编辑节点</h4>
                    <?php } else { ?>
                        <h4 class="title">节点详情</h4>
                    <?php } ?>
                    </div>
                    <div class="card-content">
                        <form id="form-node">
                            <div>
                            <?php if ($isEdit || $isNew) { ?>
                                <div class="form-group hidden">
                                    <label class="control-label">id</label>
                                    <input class="form-control" id="id" value="<?php echo $rs['id']; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Node Id</label>
                                    <input class="form-control" id="node_id" required="required" value="<?php echo $rs['node_id']; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">节点名称</label>
                                    <input class="form-control" id="name" required="required" value="<?php echo $rs['name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">地址</label>
                                    <input class="form-control" id="server" required="required" value="<?php echo $rs['server']; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">加密方式</label>
                                    <select class="form-control selectpicker" id="method" data-style="btn btn-info" data-live-search="true">
                                    <?php foreach ($ss_methods as $method) { ?>
                                        <option <?php if ($method == $rs['method']) { echo 'selected="selected"'; } ?>><?php echo $method?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">节点描述</label>
                                    <input class="form-control" id="info" value="<?php echo $rs['info']; ?>">
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="control-label">Node Id</label>
                                    <span class="form-control"><?php echo $rs['node_id']; ?></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">节点名称</label>
                                    <span class="form-control"><?php echo $rs['name']; ?></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">地址</label>
                                    <span class="form-control"><?php echo $rs['server']; ?></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">加密方式</label>
                                    <span class="form-control"><?php echo $rs['method']; ?></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">节点描述</label>
                                    <span class="form-control"><?php echo $rs['info']; ?></span>
                                </div>
                            <?php } ?>
                            </div>
                            <div>
                            <?php if ($isNew) { ?>
                                <button type="submit" id="node-add" class="btn btn-success">保存</button>
                            <?php } else if ($isEdit) { ?>
                                <button type="submit" id="node-update" class="btn btn-success">保存</button>
                                <a href="?id=<?php echo $rs['id']; ?>" class="btn btn-default">取消</a>
                                <button type="button" id="node-delete" class="btn btn-danger">删除</button>
                            <?php } else { ?>
                                <a href="?id=<?php echo $rs['id']; ?>&edit" class="btn btn-primary">编辑</a>
                            <?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php if (!$isEdit && !$isNew) { ?>
            <div class="col-sm-6">
                 <div class="card">
                    <div class="card-header" data-background-color>
                        <h4 class="title">流量图表 - 30 Days</h4>
                    </div>
                    <div class="card-content">
                        <div class="usage-box"><canvas width="16px" height="9px" class="usage-month"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                 <div class="card">
                    <div class="card-header" data-background-color>
                        <h4 class="title">流量图表 - 24 Hours</h4>
                    </div>
                    <div class="card-content">
                        <div class="usage-box"><canvas width="16px" height="9px" class="usage-day"></canvas></div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
require_once '../template/footer.php'; ?>

<!-- Chart 2.6.0 -->
<script src="asset/js/Chart.bundle.min.js"></script>
<!-- Bootstrap-select 1.12.4 -->
<link rel="stylesheet" href="asset/css/bootstrap-select.min.css">
<script src="asset/js/bootstrap-select.min.js"></script>

<script>

<?php if ($isNew) { ?>

    function add() {
        $.ajax({
            type: "POST",
            url: "ajax/admin-node.php",
            dataType: "json",
            data: {
                action: "add",
                node_id: $("#node_id").val(),
                name: $("#name").val(),
                server: $("#server").val(),
                method: $("#method").val(),
                info: $("#info").val()
            },
            success: function(data) {
                if (data.ok) {
                    new Message("操作成功", "success", 1000);
                    setTimeout(function() { location.href = "admin-node.php"; }, 1000);
                } else {
                    $("#node-add").attr("disabled", false);
                    new Message("操作失败", "error", 1000);
                }
            },
            error: function(jqXHR) {
                new Message("发生错误：" + jqXHR.status, "error", 1000);
                $("#node-add").attr("disabled", false);
            }
        });
    }

    $("#form-node").submit(function() {
        $("#node-add").attr("disabled", true);
        add();
        return false;
    });

<?php } else if ($isEdit) { ?>
    var id = <?php echo $rs['id']; ?>;

    function update() {
        $.ajax({
            type: "POST",
            url: "ajax/admin-node.php",
            dataType: "json",
            data: {
                action: "update",
                id: $("#id").val(),
                node_id: $("#node_id").val(),
                name: $("#name").val(),
                server: $("#server").val(),
                method: $("#method").val(),
                info: $("#info").val()
            },
            success: function(data) {
                if (data.ok) {
                    new Message("操作成功", "success", 1000);
                    setTimeout(function() { location.href = "admin-node-detail.php?id=" + id; }, 1000);
                } else {
                    new Message("操作失败", "error", 1000);
                    $("#node-update").attr("disabled", false);
                    $("#node-delete").attr("disabled", false);
                }
            },
            error: function(jqXHR) {
                new Message("发生错误：" + jqXHR.status, "error", 1000);
                $("#node-update").attr("disabled", false);
                $("#node-delete").attr("disabled", false);
            }
        });
    }

    $("#form-node").submit(function() {
        $("#node-update").attr("disabled", true);
        $("#node-delete").attr("disabled", true);
        update();
        return false;
    });

    function del() {
        $.ajax({
            type: "POST",
            url: "ajax/admin-node.php",
            dataType: "json",
            data: {
                action: "delete",
                id: id
            },
            success: function(data) {
                if (data.ok) {
                    new Message("操作成功", "success");
                    setTimeout(function() { location.href = "admin-node.php"; }, 1000);
                } else {
                    new Message("操作失败", "error", 1000);
                    $("#node-delete").attr("disabled", false);
                    $("#node-update").attr("disabled", false);
                }
            },
            error: function(jqXHR) {
                new Message("发生错误：" + jqXHR.status, "error", 1000);
                $("#node-delete").attr("disabled", false);
                $("#node-update").attr("disabled", false);
            }
        });
    }

    $("#node-delete").click(function() {
        if (confirm("确认删除此节点？")) {
            $("#node-delete").attr("disabled", true);
            $("#node-update").attr("disabled", true);
            del();
        }
        return false;
    });

<?php } else { ?>
    var node_id = <?php echo $rs['node_id']; ?>;
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
                    to: to + interval - 1,
                    node_id: node_id,
                    type: "days"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showChart(elem, from, to, interval, data.data);
            });
        });
    })();

    !(function() {
        var interval = 1200;
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
                    to: to + interval - 1,
                    node_id: node_id,
                    type: "20min"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showChart(elem, from, to, interval, data.data);
            });
        });
    })();
<?php } ?>
</script>