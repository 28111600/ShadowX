<?php
require_once '../config.php';
require_once '../lib/init.php';

# 退订后无法收到申请重置密码邮件

$unsubscribe = isset($_GET['confirm']);
$email = isset($_GET['email']) ? $_GET['email'] : "";
if (empty($email)) {
    die();
}
if ($unsubscribe && !empty($email)) {
    if (!empty($mailgun_key) && !empty($mailgun_domain)) {
        require '../vendor/autoload.php';

        $mailgun = new Mailgun\Mailgun($mailgun_key);

        $mailgun->post($mailgun_domain."/unsubscribes", [
            'address' => $email,
            'tag'     => '*']);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $site_name; ?></title>
    <?php include "../template/head-meta.php"; ?>
    <link rel="stylesheet" href="asset/css/unsubscribe.css">
</head>

<body>
    <div class="body">
        <div class="container">
            <div class="content">
                <div class="main">
                    <div class="wrapper">
                        <h2 class="mt0">退订邮件</h2>
                        <br>
                        <?php if ($unsubscribe) { ?>
                        <p>邮件已退订</p>
                        <?php } else { ?>
                        <p>确认退订此邮件？ <a href="?email=<?php echo $email; ?>&confirm">确定</a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>