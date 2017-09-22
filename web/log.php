<?php
$page_title = "流量日志";
require_once '../template/main.php';
require_once '../template/head.php';

$uid_log = $User->getUid();

require_once '../template/log.php';
require_once '../template/footer.php'; ?>
