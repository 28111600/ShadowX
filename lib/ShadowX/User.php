<?php
namespace ShadowX;

class User {
    private $db;
    private $table = "user";
    private $data;

    public $uid;

    function __construct($uid=0){
        global $db;
        $this->uid  = $uid;
        $this->db   = $db;
        $this->data = $this->getUser();
    }

    function getUser(){
        $datas = $this->db->select($this->table,"*",[
            "uid" => $this->uid,
            "LIMIT" => "1"
        ]);
        return $datas[0];
    }

    function GetUid(){
        return $this->data['uid'];
    }

    function GetEmail(){
        return $this->data['email'];
    }

    function GetUserName(){
        return $this->data['user_name'];
    }

    function getPort(){
         return $this->data['port'];
    }

    function getPass(){
        return $this->data['passwd'];
    }

    function getTransfer(){
        return $this->data['u'] + $this->data['d'];
    }

    function getTransferEnable(){
        return $this->data['transfer_enable'];
    }

    function getUnusedTransfer(){
        return $this->getTransferEnable() - $this->getTransfer();
    }

    function getLastUseTime(){
        return $this->data['t'];
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
