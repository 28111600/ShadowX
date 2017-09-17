<?php
require_once '../config.php';
require_once '../lib/init.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $site_name; ?></title>
    <?php include "../template/head-meta.php"; ?>
    <!-- Sticky Footer Navbar -->
    <link rel="stylesheet" href="asset/css/sticky-footer-navbar.css">
</head>

<body>
    <!-- Begin page content -->
    <div class="container">
        <div class="page-header">
            <h1>服务条款 Terms of Service </h1>
        </div>
        <p>
            <a href="<?php echo $site_url; ?>"><?php echo $site_name; ?></a>，以下简称本站。</p>
        <h3>隐私</h3>
        <p>
            <ul>
                <li>用户注册时候需要提供邮箱以及密码，并自行保管。</li>
                <li>本站会加密存储用户密码，尽量保证数据安全，但并不保证这些信息的绝对安全。</li>
                <li>因Shadowsocks服务端需要，连接密码使用明文存储。</li>
            </ul>
        </p>

        <h3>使用条款</h3>
        <p>
            <ul>
                <li>禁止使用本站服务进行任何违法恶意活动。</li>
                <li>使用任何节点，需遵循当地相关法律以及中国法律。</li>
                <li>禁止滥用本站提供的服务。</li>
                <li>任何违法使用条款的用户，我们将会删除违规账户并没收使用本站服务的权利。</li>
            </ul>
        </p>

        <h3>其它</h3>
        <p>
            <ul>
                <li>服务条款更新时，用户需要遵守最新服务条款。</li>
            </ul>
        </p>

    </div>
    <footer class="footer">
        <div class="container">
            <p class="text-muted">
                <span class="visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><strong>Copyright &copy; 2014-<?php echo date('Y'); ?> <a href="<?php echo $site_url; ?>"><?php echo $site_name; ?></a> </strong> All rights reserved.</span>
                <span class="visible-xs-inline-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block">Powered by <b>ShadowX</b> <?php echo $version; ?></span>
            </p>
        </div>
    </footer>
</body>

</html>
<!-- jQuery 3.2.1 -->
<script src="asset/js/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="asset/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="asset/js/fastclick.js"></script>