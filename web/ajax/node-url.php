<?php
require_once '../../template/main.php';

$id = $_GET['id'];
$node = new ShadowX\Node($id);
$server =  $node->getServer();
$method = $node->getMethod();
$pass = $User->getPass();
$port = $User->getPort();
?>
{
    "server":"<?php echo $server; ?>",
    "server_port":<?php echo $port; ?>,
    "password":"<?php echo $pass; ?>",
    "method":"<?php echo $method; ?>"
}