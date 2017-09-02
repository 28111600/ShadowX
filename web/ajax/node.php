<?php
require_once '../../template/main.php';
require_once '../lib/admin-check.php';

if(!empty($_POST)){
    $action = $_POST['action'];
    if ($action == 'delete') {
        $id = $_POST['id'];
        $Node = new ShadowX\Node($id);
        $Node->deleteNode();
        $result['code'] = '1';
        $result['ok'] = '1';
        echo json_encode($result);
    }
}