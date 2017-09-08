<?php
require_once '../../template/main.php';
require_once '../lib/admin-check.php';

if(!empty($_POST)){
    $action = $_POST['action'];
    if ($action == 'delete') {
        $id = $_POST['id'];
        $node = new ShadowX\Node($id);
        $node->deleteNode();
        $result['code'] = 1;
        $result['ok'] = 1;
        echo json_encode($result);
    } else if ($action == 'update') {
        $node_id = $_POST['node_id'];
        $id = $_POST['id'];
        $name = $_POST['name'];
        $server = $_POST['server'];
        $method = $_POST['method'];
        $info = $_POST['info'];
        $node = new ShadowX\Node($id);
        $node->updateNode($name,$server,$method,$info,$node_id);
        $result['code'] = 1;
        $result['ok'] = 1;
        echo json_encode($result);
    } else if ($action == 'add') {
        $node_id = $_POST['node_id'];
        $name = $_POST['name'];
        $server = $_POST['server'];
        $method = $_POST['method'];
        $info = $_POST['info'];
        ShadowX\Node::addNode($name,$server,$method,$info,$node_id);
        $result['code'] = 1;
        $result['ok'] = 1;
        echo json_encode($result);
    }
} else {
    $result['ok'] = 0;
    $result['code'] = 0;
    echo json_encode($result);
}