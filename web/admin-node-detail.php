<?php
require_once '../template/main.php';
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>节点信息
            <small>Node Information</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <?php if ($isNew) { ?>
                        <h3 class="box-title">添加节点</h3>
                    <?php } else if ($isEdit) { ?>
                        <h3 class="box-title">编辑节点</h3>
                    <?php } else { ?>
                        <h3 class="box-title">节点详情</h3>
                    <?php } ?>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                        <?php if ($isEdit || $isNew) { ?>
                            <div class="form-group hidden">
                                <label for="cate_title">id</label>
                                <input class="form-control" id="id" value="<?php echo $id;?>" >
                            </div>
                            <div class="form-group" >
                                <label for="cate_title">Node Id</label>
                                <input class="form-control" id="node_id" required="required" value="<?php echo $rs['node_id'];?>" >
                            </div>
                            <div class="form-group">
                                <label for="cate_title">节点名称</label>
                                <input class="form-control" id="name" required="required" value="<?php echo $rs['name'];?>" >
                            </div>
                            <div class="form-group">
                                <label for="cate_title">地址</label>
                                <input class="form-control" id="server" required="required" value="<?php echo $rs['server'];?>" >
                            </div>
                            <div class="form-group">
                                <label for="cate_method">加密方式</label>
                                <select class="form-control select2" id="method" style="width: 100%;">
                                <?php foreach ($ss_methods as $method) { ?>
                                    <option <?php if ($method == $rs['method']) { echo 'selected="selected"'; } ?>><?php echo $method?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">节点描述</label>
                                <input class="form-control" id="info" value="<?php echo $rs['info'];?>" >
                            </div>
                        <?php } else { ?>
                            <div class="form-group hidden">
                                <label for="cate_title">id</label>
                                <span class="form-control"><?php echo $id;?></span>
                            </div>
                            <div class="form-group" >
                                <label for="cate_title">Node Id</label>
                                <span class="form-control"><?php echo $rs['node_id'];?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">节点名称</label>
                                <span class="form-control"><?php echo $rs['name'];?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">地址</label>
                                <span class="form-control"><?php echo $rs['server'];?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_method">加密方式</label>
                                <span class="form-control"><?php echo $rs['method'];?></span>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">节点描述</label>
                                <span class="form-control"><?php echo $rs['info'];?></span>
                            </div>
                        <?php } ?>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                        <?php if ($isNew) { ?>
                            <button type="submit" class="btn btn-success">保存</button>
                        <?php } else if ($isEdit) { ?>
                            <button type="submit" class="btn btn-success">保存</button>
                            <a href="?id=<?php echo $id;?>" class="btn btn-default">取消</a>
                            <button type="button" id="node-delete" class="btn btn-danger">删除</button>
                        <?php } else { ?>
                            <a href="?id=<?php echo $id;?>&edit" class="btn btn-primary">编辑</a>
                        <?php } ?>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <?php if (!$isEdit && !$isNew) { ?>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">流量图表 - 30 Days</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="usage-box"><canvas width="16px" height="9px" class="usage-month"></canvas></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">流量图表 - 24 Hours</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="usage-box"><canvas width="16px" height="9px" class="usage-day"></canvas></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <?php } ?>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require_once '../template/footer.php'; ?>

<!-- Select2 4.0.3 -->
<script src="asset/js/select2.min.js"></script>
<!-- Chart 2.6.0 -->
<script src="asset/js/Chart.bundle.min.js"></script>

<script>
    //Initialize Select2 Elements
    $('.select2').select2();

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
                    new Message("操作成功！", "success", 1000);
                    setTimeout(function() { location.href = "admin-node.php"; }, 1000);
                } else {
                    new Message("操作失败！", "error", 1000);
                }
            },
            error: function(jqXHR) {
                new Message("发生错误：" + jqXHR.status, "error", 1000);
            }
        });
    }

    $("form").submit(function() {
        add();
        return false;
    })

<?php } else if ($isEdit) { ?>
    var id = <?php echo $id;?>;
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
                    new Message("操作成功！", "success", 1000);
                    setTimeout(function() { location.href = "admin-node-detail.php?id=" + id; }, 1000);
                } else {
                    new Message("操作失败！", "error", 1000);
                }
            },
            error: function(jqXHR) {
                new Message("发生错误：" + jqXHR.status, "error", 1000);
            }
        });
    }

    $("form").submit(function() {
        update();
        return false;
    })

    $("#node-delete").click(function() {
        if (confirm("确认删除此节点？")) {
            var id = $("#id").val();
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
                        new Message("操作成功！", "success");
                        setTimeout(function() { location.href = "admin-node.php"; }, 1000);
                    } else {
                        new Message("操作失败！", "error", 1000);
                    }
                },
                error: function(jqXHR) {
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                }
            })
        }
        return false;
    });
<?php } else { ?>
    var node_id = <?php echo $rs['node_id'];?>;
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
                    to: to,
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
        var interval = 3600;
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
                    to: to,
                    node_id: node_id,
                    type: "hours"
                }
            }).done(function(text) {
                var data = JSON.parse(text);
                showChart(elem, from, to, interval, data.data);
            });
        });
    })();
<?php } ?>
</script>