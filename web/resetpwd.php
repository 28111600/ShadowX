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
    <div class="content">
        <div>
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <div class="card">
                    <div class="card-header" data-background-color>
                        <h4 class="title">重置密码</h4>
                    </div>
                    <div class="card-content">
                        <form id="form-resetpwd">
                        <?php if ($code =='') { ?>
                            <div class="form-group has-feedback">
                                <input id="email" name="Email" type="text" class="form-control" placeholder="邮箱">
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <button type="submit" id="request" class="btn btn-info btn-simple btn-block btn-lg">发送重置邮件</button>
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
                                <button type="submit" id="resetpwd" class="btn btn-success btn-simple btn-block btn-lg">确认重置</button>
                            </div>
                        <?php } ?>
                        </form>
                        <a href="login.php" class="text-center">返回登录</a>
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