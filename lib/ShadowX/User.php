<?php
namespace ShadowX;

class User {
    public $uid;
    public $db;

    private $table = "user";

    function __construct($uid=0){
        global $db;
        $this->uid = $uid;
        $this->db  = $db;
    }

    function getUser(){
        $datas = $this->db->select($this->table,"*",[
            "uid" => $this->uid,
            "LIMIT" => "1"
        ]);
        return $datas[0];
    }

    function GetEmail(){
        return $this->UserArray()['email'];
    }

    function GetUserName(){
        return $this->UserArray()['user_name'];
    }

    function getPort(){
         return $this->getUser()['port'];
    }

    function getPass(){
        return $this->getUser()['passwd'];
    }

    function getTransfer(){
        return $this->getUser()['u'] + $this->getUser()['d'];
    }

    function getTransferEnable(){
        return $this->getUser()['transfer_enable'];
    }

    function getUnusedTransfer(){
        return $this->getTransferEnable() - $this->getTransfer();
    }

    function getLastUseTime(){
        return $this->getUser()['t'];
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
