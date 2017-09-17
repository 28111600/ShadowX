<?php

$dir = getcwd();
chdir(dirname(__FILE__));

//Version
$version = "1.0.0";

//密码最小长度
$PWD_MIN = 6;

//Set timezone
date_default_timezone_set('UTC');

spl_autoload_register(function ($class) {
    require_once str_replace('\\', '/', $class).'.php';
});

require '../vendor/autoload.php';
$db = new Medoo\Medoo([
    // required
    'database_type' => $DB_TYPE,
    'database_name' => $DB_DBNAME,
    'server' => $DB_HOST,
    'port' => $DB_PORT,
    'username' => $DB_USER,
    'password' => $DB_PWD,
    'charset' => "utf8",

    // driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

$db->query("SET NAMES utf8;");
$db->query("SET time_zone = '+00:00';");

chdir($dir);
