<?php
namespace ShadowX;

class Node {
    public $id;

    private $db;
    private $table = "ss_node";

    function __construct($id=0){
        global $db;
        $this->id  = $id;
        $this->db  = $db;
    }

    function getAllNodes(){
        $node_array = $this->db->select($this->table,"*",[
            "ORDER" => "node_id"
        ]);
        return $node_array;
    }

    function addNode($name,$server,$method,$info,$status,$node_id){
        $this->db->insert($this->table, [
            "name" => $name,
            "server" => $server,
            "method" => $method,
            "info" => $info,
            "status" => $status,
            "node_id" =>  $node_id
        ]);
        return 1;
    }
}