<?php

//Version
$version = "0.1.0";

//Set timezone
date_default_timezone_set('UTC');

//Using Mysqli
$dbc = new mysqli(DB_HOST,DB_USER,DB_PWD,DB_DBNAME);
$db_char = DB_CHARSET;
$dbc->query("SET NAMES utf8;");
$dbc->query("SET time_zone = '+0:00';");

$dbInfo['database_type'] = DB_TYPE;
$dbInfo['database_name'] = DB_DBNAME;
$dbInfo['server'] = DB_HOST;
$dbInfo['port'] = DB_PORT;
$dbInfo['username'] = DB_USER;
$dbInfo['password'] = DB_PWD;
$dbInfo['charset'] = DB_CHARSET;

require_once 'Medoo.php';
$db = new medoo([
    // required
    'database_type' => DB_TYPE,
    'database_name' => DB_DBNAME,
    'server' => DB_HOST,
    'port' => DB_PORT,
    'username' => DB_USER,
    'password' => DB_PWD,
    'charset' => DB_CHARSET,

    // driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);