<?php
require_once '../../template/main.php';

if(!empty($_POST)){
    $action = $_POST['action'];
    if ($action == 'getLogRange') {
        $node_id = isset($_POST['node_id']) ? $_POST['node_id'] : "";
        $from = isset($_POST['from']) ? $_POST['from'] : time();
        $to = isset($_POST['to']) ? $_POST['to'] : time();
        $type = isset($_POST['type']) ? $_POST['type'] : "hours";

        $Log = new ShadowX\Log($User->getUid());
        $logs = $Log->getLogsRange($from, $to, $type, $node_id, $timeoffset);
        $rows = array();
        if (count($logs) > 0) {
            foreach ($logs as $log) {
                $d['t'] = $log['t'];
                $d['u'] = $log['u'];
                $d['d'] = $log['d'];
                $rows[] = $d;
            }
            $result['code'] = 1;
            $result['ok'] = 1;
            $result['data'] = $rows;
            echo json_encode($result);
        } else {
            $result['ok'] = 0;
            $result['code'] = 0;
            echo json_encode($result);
        }
    }
}