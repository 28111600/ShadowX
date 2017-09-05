<?php
require_once '../../template/main.php';

$id = $_GET['id'];
$node = new ShadowX\Node($id);
$result['server'] = $node->getServer();
$result['server_port'] = $User->getPort();
$result['password'] = $User->getSsPasswd();
$result['method'] = $node->getMethod();
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>