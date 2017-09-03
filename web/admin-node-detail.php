<?php
require_once '../template/main.php';
require_once '../template/head.php';

if(!empty($_GET)){
    $id = $_GET['id'];
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

$array_method = array(
    "aes-256-cfb",
    "aes-256-ofb",
    "aes-192-cfb",
    "aes-192-ofb",
    "aes-128-cfb",
    "aes-128-ofb",
    "chacha20",
    "rc4",
    "rc4-md5",
    "cast5-cfb",
    "cast5-ofbs"
);
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
                        <h3 class="box-title">编辑节点</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            <div class="form-group" style="display:none" >
                                <label for="cate_title">id</label>
                                <input class="form-control" id="id" value="<?php echo $id;?>" >
                            </div>
                            <div class="form-group" >
                                <label for="cate_title">Node Id</label>
                                <input class="form-control" id="node_id" value="<?php echo $rs['node_id'];?>" >
                            </div>
                            <div class="form-group">
                                <label for="cate_title">节点名称</label>
                                <input class="form-control" id="name" value="<?php echo $rs['name'];?>" >
                            </div>
                            <div class="form-group">
                                <label for="cate_title">地址</label>
                                <input class="form-control" id="server" value="<?php echo $rs['server'];?>" >
                            </div>
                            <div class="form-group">
                                <label for="cate_method">加密方式</label>
                                <select class="form-control select2" id="method" style="width: 100%;">
                                <?php foreach ($array_method as $method) { ?>
                                    <option <?php if ($method == $rs['method']) { echo 'selected="selected"'; } ?>><?php echo $method?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cate_title">节点描述</label>
                                <input class="form-control" id="info" value="<?php echo $rs['info'];?>" >
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                        <?php if ($isNew) { ?>
                            <button type="submit" class="btn btn-success">保存</button>
                        <?php } else { ?>
                            <button type="submit" class="btn btn-success">保存</button>
                            <button type="button" id="node-delete" class="btn btn-danger">删除</button>
                        <?php } ?>
                        </div>
                    </form>
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

<!-- Select2 4.0.3 -->
<script src="asset/js/select2.full.min.js"></script>

<script>
    //Initialize Select2 Elements
    $('.select2').select2();

<?php if ($isNew) { ?>

    function add() {
        $.ajax({
            type: "POST",
            url: "ajax/node.php",
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

<?php } else { ?>

    function update() {
        $.ajax({
            type: "POST",
            url: "ajax/node.php",
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
                    setTimeout(function() { location.reload(); }, 1000);
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

<?php } ?>

    $("#node-delete").click(function() {
        if (confirm("确认删除此节点？")) {
            var id = $("#id").val();
            $.ajax({
                type: "POST",
                url: "ajax/node.php",
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
    })
</script>