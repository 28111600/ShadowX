<?php
$guest = true;
require_once '../template/main.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $site_name; ?></title>
    <?php include "head-meta.php"; ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-box-body">
            <h2 class="login-box-msg">注册</h2>
            <form id="form-register">
                <div class="form-group has-feedback">
                    <input type="text" id="name" required="required" class="form-control" placeholder="用户名">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" id="email" required="required" class="form-control" placeholder="邮箱">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="passwd" required="required" class="form-control" autocomplete="new-password" placeholder="密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="repasswd" required="required" class="form-control" autocomplete="new-password" placeholder="确认密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" id="invitecode" required="required" class="form-control" placeholder="邀请码">
                    <span class="glyphicon glyphicon-send form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <button type="submit" id="register" class="btn btn-primary btn-block btn-flat">注册</button>
                </div>
            </form>
            <a href="login.php" class="text-center">登录</a>
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
        function register() {
            $.ajax({
                type: "POST",
                url: "ajax/register.php",
                dataType: "json",
                data: {
                    action: "register",
                    name: $("#name").val(),
                    email: $("#email").val(),
                    passwd: encodeURIComponent($("#passwd").val()),
                    invitecode: $("#invitecode").val()
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("注册成功", "success", 1000);
                        setTimeout(function() { location.href = "login.php"; }, 1000);
                    } else {
                        $("#register").attr("disabled", false);
                        new Message(data.msg, "error", 1000);
                    }
                },
                error: function(jqXHR) {
                    $("#register").attr("disabled", false);
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                }
            });
        }
        $("#form-register").submit(function() {
            if ($("#passwd").val() !== $("#repasswd").val()) {
                new Message("两次填写的密码不一致", "error", 1000);
            } else {
                $("#register").attr("disabled", true);
                register();
            }
            return false;
        });
    })();
</script>