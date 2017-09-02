<?php
namespace ShadowX;

class Log {
    private $db;
    private $table = "log";

    public  $uid;
    public  $pagesize = 20;
    public  $count ;

    function __construct($uid=0){
        global $db;
        $this->uid = $uid;
        $this->db  = $db;
    }

    function getLogs($page=0,$type,$node_id,$timeoffset=0){
    if ($type == "hours"){
        $select_t = " UNIX_TIMESTAMP(FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-%d %H:00:00')) AS t ";
        $group = " GROUP BY CONCAT(log.port,FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-%d %H')) ";
    } else if ($type == "days"){
        $select_t = " UNIX_TIMESTAMP(FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-%d 00:00:00')) AS t ";
        $group = " GROUP BY CONCAT(log.port,FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-%d')) ";
    } else if ($type == "months"){
        $select_t = " UNIX_TIMESTAMP(FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-01 00:00:00')) AS t ";
        $group = " GROUP BY CONCAT(log.port,FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m')) ";
    } else {
        $select_t = " UNIX_TIMESTAMP(FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-01-01 00:00:00')) AS t ";
        $group = " GROUP BY CONCAT(log.port,FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y')) ";
    }

    $where_user = $this->uid!=0 ? " AND log.uid=".$this->uid." " : "";
    $where_node = $node_id!="" ? " AND log.node_id=".$node_id." " : "";
    $where = " WHERE log.uid = user.uid ".$where_user.$where_node.$group." ";

    $datas_count = $this->db->query("SELECT count(0) AS count FROM (SELECT log.id FROM user, log ".$where.") AS log;");
    foreach ( $datas_count as $rs ){
        $this->count = $rs["count"];
    }

    $page = max(min($page,ceil($this->count / $this->pagesize) - 1),0);

    $datas = $this->db->query("SELECT log.uid,user_name, log.port, SUM(log.u) AS u, SUM(log.d) AS d,".$select_t." FROM user, log ".$where." ORDER BY t desc,uid asc LIMIT ".($page * $this->pagesize).",".$this->pagesize.";");

    return $datas;
    }

function getLogsRange($from,$to,$type,$node_id,$timeoffset=0){
    if ($type == "10min"){
        $select_t = " floor((log.t + ".$timeoffset.") / 600) * 600 AS t ";
        $group = " GROUP BY floor((log.t + ".$timeoffset.") / 600) ";
    } else if ($type == "20min"){
        $select_t = " floor((log.t + ".$timeoffset.") / 1200) * 1200 AS t ";
        $group = " GROUP BY floor((log.t + ".$timeoffset.") / 1200) ";
    } else if ($type == "hours"){
        $select_t = " UNIX_TIMESTAMP(FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-%d %H:00:00')) AS t ";
        $group = " GROUP BY FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-%d %H') ";
    } else if ($type == "days"){
        $select_t = " UNIX_TIMESTAMP(FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-%d 00:00:00')) AS t ";
        $group = " GROUP BY FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-%d') ";
    } else if ($type == "months"){
        $select_t = " UNIX_TIMESTAMP(FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m-01 00:00:00')) AS t ";
        $group = " GROUP BY FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-%m') ";
    } else {
        $select_t = " UNIX_TIMESTAMP(FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y-01-01 00:00:00')) AS t ";
        $group = " GROUP BY FROM_UNIXTIME(log.t + ".$timeoffset.", '%Y') ";
    }

    $where_user = $this->uid!=0 ? " AND log.uid=".$this->uid." " : "";
    $where_node = $node_id!="" ? " AND log.node_id=".$node_id." " : "";
    $where_from_to = " log.t >= ".$from." AND log.t < ".$to;
    $where = " WHERE ".$where_from_to.$where_user.$where_node.$group." ";

    $datas = $this->db->query("SELECT SUM(log.u) AS u, SUM(log.d) AS d,".$select_t." FROM log ".$where." ORDER BY log.t asc;");
    return $datas;
    }
}
