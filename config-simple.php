<?php

//数据库连接信息
define('DB_HOST','localhost');
define('DB_PORT',3306);
define('DB_USER','root');
define('DB_PWD','password');
define('DB_DBNAME','db');
define('DB_CHARSET','utf8');
define('DB_TYPE','mysql');

//新用户初始流量
$default_transfer = 1024 * 1024 * 1024 * 1;

//站点名称
$site_name = "ShadowX";
$site_url  = "https://yourdomain.com/";

//密码Salt
$salt = "ShadowX";

$mail_sender = "noreply@xxx.xx";
$mailgun_key = "";
$mailgun_domain = "";