<?php
namespace ShadowX;

class User {
    private $db;
    private $table = "user";
    private $data;

    public $uid;

    function __construct($uid=-1){
        global $db;
        $this->uid  = $uid;
        $this->db   = $db;
        $this->data = $this->getUser();
    }

    function getAllUsers(){
       $datas = $this->db->select($this->table,"*");
       return $datas;
    }

    function getUser(){
        $datas = $this->db->select($this->table,"*",[
            "uid" => $this->uid,
            "LIMIT" => "1"
        ]);
        return count($datas) > 0 ? $datas[0] : [];
    }

    function getUid(){
        return $this->data['uid'];
    }

    function getEmail(){
        return $this->data['email'];
    }

    function getUserName(){
        return $this->data['user_name'];
    }

    function isAdmin(){
        return $this->db->has("ss_user_admin",[
            "uid" => $this->uid
        ]);
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

    function isEmailLogin($email,$passwd){
        return $this->db->has($this->table,[
            "AND" => [
                "email" => $email,
                "pass" => $passwd
            ]
        ]);
    }

    function getUidByEmail($email){
        $datas = $this->db->select($this->table,"*",[
            "email" => $email,
            "LIMIT" => 1
        ]);
        return $datas['0']['uid'];
    }


}
