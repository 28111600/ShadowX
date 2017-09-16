<?php
require_once '../../template/main.php';
require_once '../lib/admin-check.php';

if(!empty($_POST)){
    $action = $_POST['action'];
    if ($action == 'addtransfer') {
        $transfer = intval($_POST['transfer']);
        $uid = $_POST['uid'];
        $user = new ShadowX\User($uid);
        if ($transfer === 0) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "值需大于0或小于0";
        } else if (!$user->isExists()) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "该用户不存在";
        } else {
            $user->addTransfer($transfer);
            $result['ok'] = 1;
            $result['code'] = 1;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else if ($action == 'addinvitenum') {
        $num = intval($_POST['num']);
        $uid = $_POST['uid'];
        $user = new ShadowX\User($uid);
        if ($num === 0) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "值需大于0或小于0";
        } else if (!$user->isExists()) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "该用户不存在";
        } else {
            $user->addInviteNum($num);
            $result['ok'] = 1;
            $result['code'] = 1;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
        $result['ok'] = 0;
        $result['code'] = 0;
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
} else {
    $result['ok'] = 0;
    $result['code'] = 0;
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}