<?php
namespace ShadowX;

class User {
    public $uid;
    public $db;

    private $table = "user";

    function  __construct($uid=0){
        global $db;
        $this->uid = $uid;
        $this->db  = $db;
    }

    function getUserArray(){
        $datas = $this->db->select($this->table,"*",[
            "uid" => $this->uid,
            "LIMIT" => "1"
        ]);
        return $datas[0];
    }

    function  getPort(){
         return $this->getUserArray()['port'];
    }

    function  getPass(){
        return $this->getUserArray()['passwd'];
    }

    function getTransfer(){
        return $this->getUserArray()['u'] + $this->getUserArray()['d'];
    }

    function  getTransferEnable(){
        return $this->getUserArray()['transfer_enable'];
    }

    function getUnusedTransfer(){
        return $this->getTransferEnable() - $this->getTransfer();
    }

    function getLastUseTime(){
        return $this->getUserArray()['t'];
    }

    function  addTransfer($transfer=0){
        $transfer = $this->getTransferEnable() + $transfer;
        $this->db->update($this->table,[
            "transfer_enable" => $transfer
        ],[
            "uid" => $this->uid
        ]);
    }

    function setSsPass($pass){
        $this->db->update($this->table,[
            "passwd" => $pass
        ],[
            "uid" => $this->uid
        ]);
    }
}
