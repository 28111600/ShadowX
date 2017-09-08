<?php
require_once 'config.php';
require_once 'lib/init.php';

if (count($argv) > 1) {
    $pwd = $argv[1];
    if (!empty($pwd)) {
        $pwd = ShadowX\Utility::getPwdHash($pwd);
        echo $pwd;
    }
}
