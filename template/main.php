<?php
require_once '../config.php';
require_once '../lib/init.php';

$timeoffset = (isset($_COOKIE["timezone"]) ? $_COOKIE["timezone"] * 3600 : 0);

$User = new \ShadowX\User(0);
?>