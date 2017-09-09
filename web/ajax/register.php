<?php
require_once '../../config.php';
require_once '../../lib/init.php';

$email = strtolower($_POST['email']);
$name = strtolower($_POST['name']);
$passwd = urldecode($_POST['passwd']);
$invitecode = $_POST['invitecode'];

if (!ShadowX\Utility::IsEmailLegal($email)) {
    $result['msg'] = "邮箱无效";
    $result['ok'] = 0;
    $result['code'] = 0;
} else if (ShadowX\User::IsEmailUsed($email)) {
    $result['msg'] = "邮箱已被使用";
    $result['ok'] = 0;
    $result['code'] = 0;
} else if (ShadowX\User::IsUsernameUsed($name)){
    $result['msg'] = "用户名已经被使用";
    $result['ok'] = 0;
    $result['code'] = 0;
} else if (strlen($passwd) < 6) {
    $result['msg'] = "密码太短";
    $result['ok'] = 0;
    $result['code'] = 0;
} else if (strlen($name) < 5){
    $result['msg'] = "用户名太短";
    $result['ok'] = 0;
    $result['code'] = 0;
} else if (!ShadowX\Invite::isInviteCodeOk($invitecode)) {
    $result['msg'] = "邀请码有误";
    $result['ok'] = 0;
    $result['code'] = 0;
} else {

    $passwd = ShadowX\Utility::getPwdHash($passwd);
    $ref_by = ShadowX\Invite::getInviteRef($invitecode);
    $invite_num = 0;
    $ip = ShadowX\Utility::geoIP();
    ShadowX\User::Register($name,$email,$passwd,$default_transfer,$invite_num,$ref_by,$ip);
    $uid = ShadowX\User::getUidByEmail($email);
    ShadowX\Invite::setInviteCodeUsed($invitecode,$uid);

    $result['ok'] = 1;
    $result['code'] = 1;

    if (!empty($mailgun_key) && !empty($mailgun_domain)) {
        require '../../vendor/autoload.php';
        $mailgun = new Mailgun\Mailgun($mailgun_key);

        $content = ShadowX\Utility::renderTpl("../../template/mail.tpl", [
            "content" => '<p>你好 '.$name.'!</p>'.
                        '<p>你已成功注册 <a href="'.$site_url.'">'.$site_name.'</a> 。</p>']);

        $mailgun->sendMessage($mailgun_domain, [
            'from'    => $mail_sender,
            'to'      => $email,
            'subject' => $site_name." 注册成功",
            'html'    => $content]);
    }
}
echo json_encode($result);