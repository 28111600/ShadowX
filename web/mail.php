<?php
require_once '../template/main.php';
require_once '../template/head.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>邮件
            <small>Email</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-9 col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">发送邮件</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form id="form-mail">
                        <div>
                            <div class="form-group has-feedback">
                                <label class="control-label">标题</label>
                                <input class="form-control" id="title" required="required">
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label">收件人</label>
                                <input class="form-control" type="email" id="receiver" required="required">
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label">内容</label>
                                <textarea class="form-control" id="content"></textarea>
                            </div>
                        </div><!-- /.box-body -->
                        <div>
                            <button type="submit" id="mail-send" class="btn btn-primary">发送</button>
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

<!-- TinyMCE 4.6.6 -->
<script src="asset/js/tinymce/tinymce.min.js"></script>
<!-- jQuery query 2.1.7 -->
<script src="asset/js/jquery.query.js"></script>
<!-- isMobile -->
<script src="asset/js/isMobile.min.js"></script>

<script>
    !(function() {
        if (isMobile.any) {
            var plugins = [
                'autolink',
                'searchreplace ',
                'insertdatetime textcolor',
            ];
            var toolbar = 'undo redo | forecolor backcolor | bold italic';
            var menubar = false;
        } else {
            var plugins = [
                'autolink link print',
                'searchreplace ',
                'insertdatetime table paste textcolor',
            ];
            var toolbar = 'insertfile undo redo | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | link | html';
            var menubar = true;
        }
        tinymce.init({
            selector: "#content",
            language: "zh_CN",
            height: 200,
            menubar: menubar,
            plugins: plugins,
            toolbar: toolbar,
            insertdatetime_formats: ["%Y-%m-%d %H:%M:%S", "%Y-%m-%d", "%H:%M:%S"],
            branding: false
        });
    })();

    !(function() {
        var receiver = $.query.get("receiver");
        if (receiver) {
            $("#receiver").val(receiver);
        }
    })();

    !(function() {
        function send() {
            $.ajax({
                type: "POST",
                url: "ajax/admin-mail.php",
                dataType: "json",
                data: {
                    action: "send",
                    title: $("#title").val(),
                    receiver: $("#receiver").val(),
                    content: tinymce.get("content").getContent()
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("操作成功", "success", 1000);
                        $("#mail-send").attr("disabled", false);
                    } else {
                        new Message("操作失败", "error", 1000);
                        $("#mail-send").attr("disabled", false);
                    }
                },
                error: function(jqXHR) {
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                    $("#mail-send").attr("disabled", false);
                }
            });
        }

        $("#form-mail").submit(function() {
            $("#mail-send").attr("disabled", true);
            send();
            return false;
        });
    })();
</script>