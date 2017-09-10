<?php
require_once '../../config.php';
require_once '../../lib/init.php';

$email = strtolower($_POST['email']);
$passwd = ShadowX\Utility::getPwdHash(urldecode($_POST['passwd']));
$rem = $_POST['remember_me'];

if (ShadowX\User::isEmailLogin($email, $passwd)) {
    $result['code'] = 1;
    $result['ok'] = 1;

    if($rem == "week"){
        $expire = 3600 * 24 * 7;
    }else{
        $expire = 3600 * 24 * 1;
    }

    $uid = ShadowX\User::getUidByEmail($email);

    $t = time() + $expire;
    $passwd_cookie = ShadowX\Utility::getPwdHash($passwd);
    setcookie("uid", $uid, $t, "/");
    setcookie("user_pwd", $passwd_cookie, $t, "/");
    setcookie("user_email", $email, $t, "/");
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} else {
    $result['ok'] = 0;
    $result['code'] = 0;
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}