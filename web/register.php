<?php
$guest = true;
require_once '../template/main.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name; ?></title>
    <link href="asset/favicon.ico" rel="shortcut icon">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="asset/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="asset/css/adminlte.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="asset/css/skins/skin-black.min.css">
    <!-- App -->
    <link rel="stylesheet" href="asset/css/app.css">
    <!-- Messg -->
    <link rel="stylesheet" href="asset/css/messg.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="asset/js/html5shiv.min.js"></script>
    <script src="asset/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-box-body">
            <h2 class="login-box-msg">注册</h2>
            <form id="form-register">
                <div class="form-group has-feedback">
                    <input type="text" id="name" required="required" class="form-control" placeholder="用户名"/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" id="email" required="required" class="form-control" placeholder="邮箱"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="passwd" required="required" class="form-control" autocomplete="new-password" placeholder="密码"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" id="repasswd" required="required" class="form-control" autocomplete="new-password" placeholder="确认密码"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" id="invitecode" required="required" class="form-control" placeholder="邀请码"/>
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