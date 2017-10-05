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

            require '../vendor/autoload.php';
            $mailgun = new Mailgun\Mailgun($mailgun_key);

            $content = ShadowX\Utility::renderTpl("../template/mail.tpl",[
                "content" => '<p>你好 '.$User->getUserName().'!</p>'.
                            '<p>你在 '.date("Y-m-d H:i:s").' 修改了密码。</p>'.
                            '<p>IP: '.ShadowX\Utility::geoIP().'</p>']);

            $mailgun->sendMessage($mailgun_domain, [
                'from'    => $mail_sender,
                'to'      => $User->getEmail(),
                'subject' => $site_name." 密码已修改",
                'html'    => $content]);

            $result['ok'] = 1;
            $result['code'] = 1;
        }
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else if ($action == 'addinvitecode') {
        if ($User->getInviteNum() <= 0) {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "操作有误";
        } else {
            ShadowX\Invite::addInviteCode($User->getUid());
            $User->addInviteNum(-1);
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