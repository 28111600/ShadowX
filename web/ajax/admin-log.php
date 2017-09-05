<?php
require_once '../../template/main.php';
require_once '../lib/admin-check.php';

if(!empty($_POST)){
    $action = $_POST['action'];
    if ($action == 'getLogRange') {
        $uid = isset($_POST['uid']) ? $_POST['uid'] : -1;
        $node_id = isset($_POST['node_id']) ? $_POST['node_id'] : "";
        $from = isset($_POST['from']) ? $_POST['from'] : time();
        $to = isset($_POST['to']) ? $_POST['to'] : time();
        $Log = new ShadowX\Log($uid);
        $logs = $Log->getLogsRange($from, $to, '20min', $node_id, $timeoffset);
        $rows = array();
        if (count($logs) > 0) {
            foreach ($logs as $log) {
                $d['t'] = $log['t'];
                $d['u'] = $log['u'];
                $d['d'] = $log['d'];
                $rows[] = $d;
            }
            $result['code'] = '1';
            $result['ok'] = '1';
            $result['data'] = $rows;
            echo json_encode($result);
        } else {
            $result['code'] = '0';
        }
    }
}