<?php
require_once '../../config.php';
require_once '../../lib/init.php';


if(!empty($_POST)){
    $action = $_POST['action'];
    if ($action == 'request') {
        $email = strtolower($_POST['email']);

        $uid = ShadowX\User::getUidByEmail($email);

        $user = new ShadowX\User($uid);
        if ($user->isExists()) {
            $code = $user->addResetCode();

            if (!empty($mailgun_key) && !empty($mailgun_domain)) {
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
            } else {
                $result['ok'] = 0;
                $result['code'] = 0;
                $result['msg'] = "邮件服务配置有误";
            }
        } else {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "该邮箱未注册";

        }
        echo json_encode($result);
    }
}