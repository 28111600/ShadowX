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
    (function() {
        function login() {
            $.ajax({
                type: "POST",
                url: "ajax/login.php",
                dataType: "json",
                data: {
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
                        new Message("登录失败", "error", 1000);
                    }
                },
                error: function(jqXHR) {
                    $("#login").attr("disabled", false);
                    new Message("发生错误：" + jqXHR.status, "error", 1000);
                }
            });
        }
        $("#form-login").submit(function() {
            login();
            $("#login").attr("disabled", true);
            return false;
        });
    })();
</script>