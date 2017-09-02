<?php
$url = parse_url($_SERVER['REQUEST_URI']);
$isPageLogin = ($url['path'] === '/login.php');

//检测是否登录，若没登录则转向登录界面
if(isset($_COOKIE['uid']) && $_COOKIE['uid'] != '') {
    $uid        = $_COOKIE['uid'];
    $user_email = $_COOKIE['user_email'];
    $user_pwd   = $_COOKIE['user_pwd'];

    $User = new ShadowX\User($uid);

    $pwd = ShadowX\Utility::getPwdHash($User->GetPasswd());
    return ;
    if($pwd !== $user_pwd || $pwd === null || $user_pwd === null){
        session_start();
        $t = time() - 3600;
        setcookie("user_pwd", "", $t, "/");
        setcookie("uid", "", $t, "/");
        setcookie("user_email", "", $t, "/");
        header("Location: login.php");
        exit();
    } else {
        if ($isPageLogin) {
            header("Location: ./");
            exit();
        }
    }
} else {
    if (!$isPageLogin) {
        header("Location: login.php");
        exit();
    }
}