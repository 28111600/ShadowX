<?php

//数据库连接信息
$DB_HOST    = "localhost";
$DB_PORT    = 3306;
$DB_USER    = 'user';
$DB_PWD     = 'password';
$DB_DBNAME  = 'db';
$DB_CHARSET = 'utf8';
$DB_TYPE    = 'mysql';

//可用加密方式
$ss_methods = array(
    "aes-128-cfb",
    "aes-256-cfb",
    "chacha20",
    "rc4",
    "rc4-md5",
);

//新用户初始流量
$default_transfer = 1024 * 1024 * 1024 * 1;

//站点名称
$site_name = "ShadowX";
$site_url  = "https://yourdomain.com";

//密码Salt
$salt = "";

$mail_sender    = "noreply@xxx.xx";
$mailgun_key    = "";
$mailgun_domain = "";