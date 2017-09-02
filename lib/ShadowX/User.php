<?php
namespace ShadowX;

class User {
    public $uid;
    public $db;

    private $table = "user";
    private $data;
    function __construct($uid=0){
        global $db;
        $this->uid  = $uid;
        $this->db   = $db;
        $this->data = getUser();
    }

    function getUser(){
        $datas = $this->db->select($this->table,"*",[
            "uid" => $this->uid,
            "LIMIT" => "1"
        ]);
        return $datas[0];
    }

    function GetEmail(){
        return $data['email'];
    }

    function GetUserName(){
        return $data['user_name'];
    }

    function getPort(){
         return $data['port'];
    }

    function getPass(){
        return $data['passwd'];
    }

    function getTransfer(){
        return $data['u'] + data['d'];
    }

    function getTransferEnable(){
        return $data['transfer_enable'];
    }

    function getUnusedTransfer(){
        return $this->getTransferEnable() - $this->getTransfer();
    }

    function getLastUseTime(){
        return $data['t'];
    }

    function addTransfer($transfer=0){
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
