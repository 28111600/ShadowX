<?php
namespace ShadowX;

class User {
    private $db;
    private static $table = "user";
    private $data;

    public $uid;

    function __construct($uid=-1){
        global $db;
        $this->uid  = $uid;
        $this->db   = $db;
        $this->data = $this->getUser();
    }

    static function getAllUsers(){
        global $db;
        $datas = $db->select(self::$table,"*");
        return $datas;
    }

    function getUser(){
        $datas = $this->db->select(self::$table,"*",[
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
        return $this->data['is_admin'];
    }

    function getPort(){
         return $this->data['port'];
    }

    function getSsPasswd(){
        return $this->data['passwd'];
    }

    function getPasswd(){
        return $this->data['pass'];
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
        $this->db->update(self::$table,[
            "transfer_enable" => $transfer
        ],[
            "uid" => $this->uid
        ]);
    }

    function setSsPass($pass){
        $this->db->update(self::$table,[
            "passwd" => $pass
        ],[
            "uid" => $this->uid
        ]);
    }

    static function isEmailLogin($email,$passwd){
        global $db;
        return $db->has(self::$table,[
            "AND" => [
                "email" => $email,
                "pass" => $passwd
            ]
        ]);
    }

    static function getUidByEmail($email){
        global $db;
        $datas = $db->select(self::$table,"*",[
            "email" => $email,
            "LIMIT" => 1
        ]);
        return $datas['0']['uid'];
    }


}
