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
        return $db->select(static::$table,"*");
    }

    function getUser(){
        $datas = $this->db->select(static::$table,"*",[
            "uid" => $this->uid,
            "LIMIT" => 1
        ]);
        return count($datas) > 0 ? $datas[0] : [];
    }

    function getUid(){
        return $this->data['uid'];
    }

    function isExists(){
        return count($this->data) > 0;
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

    function getRefBy(){
        return $this->data['ref_by'];
    }

    function getLastUseTime(){
        return $this->data['t'];
    }

    function getInviteNum(){
        return $this->data['invite_num'];
    }

    function addTransfer($transfer=0){
        $transfer = $this->getTransferEnable() + $transfer;
        $this->db->update(static::$table,[
            "transfer_enable" => $transfer
        ],[
            "uid" => $this->uid
        ]);
    }

    function setSsPass($pass){
        $this->db->update(static::$table,[
            "passwd" => $pass
        ],[
            "uid" => $this->uid
        ]);
    }

    function setPasswd($passwd){
        $this->db->update(static::$table,[
            "pass" => $passwd
        ],[
            "uid" => $this->uid
        ]);
    }

    function addResetCode(){
        $t = time();
        $expire = $t + 3600 * 24;
        $code = md5($t).md5($this->uid);
        $code = sha1($code);
        $this->db->insert("ss_reset_pwd",[
            "expire" => $expire,
            "uid" => $this->uid,
            "code" => $code
        ]);
        return $code;
    }

    static function isResetCodeValid($code){
        global $db;
        return $db->has("ss_reset_pwd",[
            "user_name" => $username
        ]);
    }

    static function IsUsernameUsed($username){
        global $db;
        return $db->has(static::$table,[
            "user_name" => $username
        ]);
    }

    static function IsEmailUsed($email){
        global $db;
        return $db->has(static::$table,[
            "email" => $email
        ]);
    }

    static function isEmailLogin($email,$passwd){
        global $db;
        return $db->has(static::$table,[
            "AND" => [
                "email" => $email,
                "pass" => $passwd
            ]
        ]);
    }

    static function getUidByEmail($email){
        global $db;
        $datas = $db->select(static::$table,"*",[
            "email" => $email,
            "LIMIT" => 1
        ]);
        return count($datas) > 0 ? $datas[0]['uid'] : [];
    }
    
    static function GetLastPort(){
        global $db;
        $datas = $db->select(static::$table,"*",[
            "ORDER" => ["port" => "DESC"],
            "LIMIT" => 1
        ]);
        return $datas[0]['port'];
    }

    static function Register($username,$email,$pass,$transfer,$invite_num,$ref_by,$ip){
        $sspass = Utility::getRandomChar(8);

        global $db;
        $db->insert(static::$table,[
            "user_name" => $username,
            "email" => $email,
            "pass" => $pass,
            "passwd" => $sspass,
            "t" => 0,
            "u" => 0,
            "d" => 0,
            "transfer_enable" => $transfer,
            "port" => static::GetLastPort() + 1,
            "invite_num" => $invite_num,
            "reg_date" => time(),
            "reg_ip" => $ip,
            "ref_by" => $ref_by
        ]);
    }
}
