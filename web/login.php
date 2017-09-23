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
    <div class="content">
        <div>
            <div class="login-box">
                <div class="card">
                    <div class="card-header" data-background-color>
                        <h4 class="title">登录</h4>
                    </div>
                    <div class="card-content">
                        <form id="form-login">
                            <div class="form-group has-feedback">
                                <input id="email" type="email" required="required" class="form-control" placeholder="邮箱">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input id="passwd" type="password" required="required" class="form-control" placeholder="密码">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <button type="submit" id="login" class="btn btn-info btn-simple btn-block btn-lg">登录</button>
                        </form>
                        <a href="register.php" class="text-center">注册</a>
                        <a href="resetpwd.php" class="pull-right">忘记密码</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
require_once '../template/footer-script.php'; ?>

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
                    remember_me: true
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