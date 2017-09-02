<?php
if(!$User->isAdmin()){
    header('HTTP/1.1 404 Not Found');
    header("status: 404 Not Found");
    exit();
}