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
            <h2 class="login-box-msg">登录</h2>
            <form id="form-login">
                <div class="form-group has-feedback">
                    <input id="email" type="email" required="required" class="form-control" placeholder="邮箱">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input id="passwd" type="password" required="required" class="form-control" placeholder="密码">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox">
                            <label><input id="remember_me" value="week" type="checkbox">记住我</label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" id="login" class="btn btn-primary btn-block btn-flat">登录</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <a href="register.php" class="text-center">注册</a>
            <a href="resetpwd.php" class="pull-right">忘记密码</a>
            
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
        function login() {
            $.ajax({
                type: "POST",
                url: "ajax/login.php",
                dataType: "json",
                data: {
                    action: "login",
                    email: $("#email").val(),
                    passwd: encodeURIComponent($("#passwd").val()),
                    remember_me: $("#remember_me").val()
                },
                success: function(data) {
                    if (data.ok) {
                        new Message("登录成功", "success", 1000);
                        setTimeout(function() { location.reload(); }, 1000);
                    } else {
                        $("#login").attr("disabled", false);
                        new Message(data.msg, "error", 1000);
                    }
                },
                error: function(jqXHR) {
                    $("#login").attr("disabled", false);
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                }
            });
        }
        $("#form-login").submit(function() {
            $("#login").attr("disabled", true);
            login();
            return false;
        });
    })();
</script>