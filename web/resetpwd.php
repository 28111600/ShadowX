<?php
$guest = true;
require_once '../template/main.php';

$code = isset($_GET['code']) ? $_GET['code'] : '';
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $site_name; ?></title>
    <?php include "head-meta.php"; ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-box-body">
            <h2 class="login-box-msg">重置密码</h2>
            <form id="form-resetpwd">
            <?php if ($code =='') { ?>
                <div class="form-group has-feedback">
                    <input id="email" name="Email" type="text" class="form-control" placeholder="邮箱">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <button type="submit" id="request" class="btn btn-primary btn-block btn-flat">发送重置邮件</button>
                </div>
            <?php } else { ?>
                <div class="form-group has-feedback">
                    <input type="hidden" id="code" class="form-control" value="<?php echo $code; ?>">
                </div>
                <div class="form-group has-feedback">
                    <input id="email" name="Email" type="text" class="form-control" placeholder="邮箱">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="passwd" class="form-control" autocomplete="new-password" placeholder="新密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="repasswd" class="form-control" autocomplete="new-password" placeholder="确认密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <button type="submit" id="resetpwd" class="btn btn-primary btn-block btn-flat">确认重置</button>
                </div>
            <?php } ?>
            </form>
            <a href="login.php" class="text-center">返回登录</a>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
</body>

</html>
<!-- jQuery 3.2.1 -->
<script src="asset/js/jquery.min.js"></script>
<!-- jQuery Cookit 1.4.1 -->
<script src="asset/js/jquery.cookie.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="asset/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="asset/js/fastclick.js"></script>
<!-- AdminLTE -->
<script src="asset/js/adminlte.min.js"></script>
<!-- AdminLTE App -->
<script src="asset/js/adminlte.app.min.js"></script>
<!-- App -->
<script src="asset/js/app.js"></script>
<!-- Messg -->
<script src="asset/js/messg.min.js"></script>

<script>
    !(function() {
    <?php if ($code == '') { ?>
        function request() {
            $.ajax({
                type: "POST",
                url: "ajax/resetpwd.php",
                dataType: "json",
                data: {
                    action: "request",
                    email: $("#email").val(),
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("已发送重置邮件", "success", 1000);
                        setTimeout(function() { location.href = "index.php"; }, 1000);
                    } else {
                        $("#request").attr("disabled", false);
                        new Message(data.msg, "error", 1000);
                    }
                },
                error: function(jqXHR) {
                    $("#request").attr("disabled", false);
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                }
            });
        }
        $("#form-resetpwd").submit(function() {
            $("#request").attr("disabled", true);
            request();
            return false;
        });
    <?php } else { ?>
        function resetpwd() {
            $.ajax({
                type: "POST",
                url: "ajax/resetpwd.php",
                dataType: "json",
                data: {
                    action: "resetpwd",
                    code: $("#code").val(),
                    email: $("#email").val(),
                    passwd: $("#passwd").val(),
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("密码已重置", "success", 1000);
                        setTimeout(function() { location.href = "index.php"; }, 1000);
                    } else {
                        $("#resetpwd").attr("disabled", false);
                        new Message(data.msg, "error", 1000);
                    }
                },
                error: function(jqXHR) {
                    $("#resetpwd").attr("disabled", false);
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                }
            });
        }
        $("#form-resetpwd").submit(function() {
            if ($("#passwd").val() !== $("#repasswd").val()) {
                new Message("两次填写的密码不一致", "error", 1000);
            } else {
                $("#resetpwd").attr("disabled", true);
                resetpwd();
            }
            return false;
        });
    <?php } ?>
    })();
</script>