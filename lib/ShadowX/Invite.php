<?php
namespace ShadowX;

class Invite {
    private $db;
    private static $table = "ss_invite";

    public $uid;

    function __construct($uid=-1){
        global $db;
        $this->uid  = $uid;
        $this->db   = $db;
    }

    function getInviteCodes(){
        return $this->db->select(static::$table,"*",[
            "uid" => $this->uid
        ]);
    }

    static function isInviteCodeOk($invitecode){
        global $db;
        return $db->has(static::$table,[
            "AND" => [
                "code" => $invitecode,
                "status" => 1
            ]
        ]);
    }

    static function getInviteRef($invitecode){
        global $db;
        $datas = $db->select(static::$table,"*",[
            "AND" => [
                "code" => $invitecode
            ]
        ]);
        return $datas[0]['uid'];
    }

    static function setInviteCodeUsed($invitecode,$uid){
        global $db;
        $db->update(static::$table,[
            "status" => 0,
            "used_uid" => $uid
        ],[
            "code" => $invitecode
        ]);
    }

    static function addInviteCode($uid){
        global $db;
        $code = Utility::getGUID();
        $db->insert(static::$table,[
            "uid" => $uid,
            "code" => $code,
            "status" => 1
        ]);
    }
}
