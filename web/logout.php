<?php
session_start();
$t = time() - 3600;
setcookie("user_pwd", "", $t, "/");
setcookie("uid", "", $t, "/");
setcookie("user_email", "", $t, "/");
header("Location: login.php");
exit();