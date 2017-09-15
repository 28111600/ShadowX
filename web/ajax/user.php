<?php
require_once '../../template/main.php';

if(!empty($_POST)){
    $action = $_POST['action'];
    if ($action == 'sspasswd') {
        $passwd = !empty($_POST['passwd']) ? $_POST['passwd'] : ShadowX\Utility::getRandomChar(8);
        $User->setSsPass($passwd);
        $result['ok'] = 1;
        $result['code'] = 1;
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else if ($action == 'passwd') {
        $passwd = urldecode($_POST['passwd']);
        if (strlen($passwd) < $PWD_MIN) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "密码长度过短";
        } else {
            $passwd = ShadowX\Utility::getPwdHash($passwd);
            $User->setPasswd($passwd);
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