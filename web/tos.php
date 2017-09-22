<?php
require_once '../config.php';
require_once '../lib/init.php';
?>
<html>

<head>
    <title><?php echo $site_name; ?></title>
    <?php include "../template/head-meta.php"; ?>
</head>

<body class="hold-transition login-page">
    <div class="content">
        <div>
            <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                <div class="card">
                    <div class="card-header" data-background-color>
                        <h3 class="title">服务条款 <small>Terms of Service</small></h2>
                    </div>
                    <div class="card-content">
                        <p>
                            <a href="<?php echo $site_url; ?>"><?php echo $site_name; ?></a>，以下简称本站。</p>
                        <h4>隐私</h4>
                        <p>
                            <ul>
                                <li>用户注册时候需要提供邮箱以及密码，并自行保管。</li>
                                <li>本站会加密存储用户密码，尽量保证数据安全，但并不保证这些信息的绝对安全。</li>
                                <li>因Shadowsocks服务端需要，连接密码使用明文存储。</li>
                            </ul>
                        </p>
                        <h4>使用条款</h4>
                        <p>
                            <ul>
                                <li>禁止使用本站服务进行任何违法恶意活动。</li>
                                <li>使用任何节点，需遵循当地相关法律以及中国法律。</li>
                                <li>禁止滥用本站提供的服务。</li>
                                <li>任何违法使用条款的用户，我们将会删除违规账户并没收使用本站服务的权利。</li>
                            </ul>
                        </p>
                        <h4>其它</h4>
                        <p>
                            <ul>
                                <li>服务条款更新时，用户需要遵守最新服务条款。</li>
                            </ul>
                        </p>
                        <br>
                        
                    </div>
                </div>
                <div class="text-center">
                    <span>Copyright &copy; 2014-<?php echo date('Y'); ?> <a href="<?php echo $site_url; ?>"><?php echo $site_name; ?></a> All rights reserved.</span>
                    <span>Powered by <b>ShadowX</b> <?php echo $version; ?></span>
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