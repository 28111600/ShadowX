<?php
require_once '../../template/main.php';
require_once '../lib/admin-check.php';

if(!empty($_POST)){
    $action = $_POST['action'];
    if ($action == 'send') {
        $title = $_POST['title'];
        $receiver = $_POST['receiver'];
        $sender = $_POST['sender'];
        $content = $_POST['content'];

        if (!empty($mailgun_key) && !empty($mailgun_domain)) {
            require '../vendor/autoload.php';
            $mailgun = new Mailgun\Mailgun($mailgun_key);

            $mailgun->sendMessage($mailgun_domain, [
                'from'    => $sender,
                'to'      => $receiver,
                'subject' => $title,
                'html'    => $content]);

            $result['code'] = 1;
            $result['ok'] = 1;
        } else {
            $result['ok'] = 0;
            $result['code'] = 0;
            $result['msg'] = "邮件服务配置有误";

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