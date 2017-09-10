<?php
require_once '../../config.php';
require_once '../../lib/init.php';


if(!empty($_POST)){
    $action = $_POST['action'];
    if ($action == 'request') {
        $email = strtolower($_POST['email']);
        $uid = ShadowX\User::getUidByEmail($email);

        $user = new ShadowX\User($uid);
        if (!$user->isExists()) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "该邮箱未注册";
        } else if (empty($mailgun_key) || empty($mailgun_domain)) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "邮件服务配置有误";
        } else if (ShadowX\ResetPwd::getCount($uid) > 5) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "24小时重置申请到达上限";
        } else {
            $code = ShadowX\ResetPwd::addResetCode($user->getUid());

            require '../../vendor/autoload.php';
            $mailgun = new Mailgun\Mailgun($mailgun_key);

            $content = ShadowX\Utility::renderTpl("../../template/mail.tpl",[
                "content" => '<p>你好 '.$user->getUserName().'!</p>'.
                            '<p>点击下面的链接来重置密码：</p>'.
                            '<p><a href="'.$site_url."/resetpwd.php?code=".$code.'">'.$site_url."/resetpwd.php?code=".$code.'</a></p>'.
                            '<p>如果你没有请求重置密码，请忽略并删除这封邮件。</p>']);

            $mailgun->sendMessage($mailgun_domain, [
                'from'    => $mail_sender,
                'to'      => $user->getEmail(),
                'subject' => $site_name." 重置密码",
                'html'    => $content]);

            $result['ok'] = 1;
            $result['code'] = 1;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else if ($action == 'resetpwd') {
        $code = $_POST['code'];
        $email = strtolower($_POST['email']);
        $passwd = urldecode($_POST['passwd']);
        $uid = ShadowX\User::getUidByEmail($email);

        $user = new ShadowX\User($uid);
        if (!$user->isExists()) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "该邮箱未注册";
        } else if (!ShadowX\ResetPwd::isResetCodeValid($uid,$code)) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "链接无效";
        } else if (strlen($passwd) < $PWD_MIN) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "密码长度过短";
        } else if (empty($mailgun_key) || empty($mailgun_domain)) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "邮件服务配置有误";
        } else {
            $passwd = ShadowX\Utility::getPwdHash($passwd);
            $user->setPasswd($passwd);
            ShadowX\ResetPwd::deleteResetCode($code);

            require '../../vendor/autoload.php';
            $mailgun = new Mailgun\Mailgun($mailgun_key);

            $content = ShadowX\Utility::renderTpl("../../template/mail.tpl",[
                "content" => '<p>你好 '.$user->getUserName().'!</p>'.
                            '<p>你在 '.date("Y-m-d H:i:s").' 重置了密码。</p>'.
                            '<p>IP: '.ShadowX\Utility::geoIP().'</p>']);

            $mailgun->sendMessage($mailgun_domain, [
                'from'    => $mail_sender,
                'to'      => $user->getEmail(),
                'subject' => $site_name." 密码已重置",
                'html'    => $content]);

            $result['ok'] = 1;
            $result['code'] = 1;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}