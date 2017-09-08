<?php
namespace ShadowX;

class Node {
    public $id;

    private $db;
    private static $table = "ss_node";
    private $data;

    function __construct($id=-1){
        global $db;
        $this->id   = $id;
        $this->db   = $db;
        $this->data = $this->getNode();
    }

    function getNode(){
        $datas = $this->db->select(self::$table,"*",[
            "id" => $this->id,
            "LIMIT" => "1"
        ]);
        return count($datas) > 0 ? $datas[0] : [];
    }

    static function getAllNodes(){
        global $db;
        return $db->select(self::$table,"*",[
            "ORDER" => "node_id"
        ]);
    }

    static function addNode($name,$server,$method,$info,$node_id){
        global $db;
        $db->insert(self::$table, [
            "name" => $name,
            "server" => $server,
            "method" => $method,
            "info" => $info,
            "node_id" =>  $node_id
        ]);
        return 1;
    }
    
    function updateNode($name,$server,$method,$info,$node_id){
        $this->db->update(self::$table, [
            "name" => $name,
            "server" => $server,
            "method" => $method,
            "info" => $info,
            "node_id" =>  $node_id
        ],[
            "id[=]"  => $this->id
        ]);
        return 1;
    }

    function deleteNode(){
        $this->db->delete(self::$table,[
            "id" => $this->id
        ]);
    }

    function getServer(){
        return $this->data['server'];
    }

    function getMethod(){
        return $this->data['method'];
    }

}