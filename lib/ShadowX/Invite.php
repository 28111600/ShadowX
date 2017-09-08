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
        return $this->db->select(self::$table,"*",[
            "uid" => $this->uid
        ]);
    }

    static function isInviteCodeOk($invitecode){
        global $db;
        return $db->has(self::$table,[
            "AND" => [
                "code" => $invitecode,
                "status" => 1
            ]
        ]);
    }

    static function getInviteRef($invitecode){
        global $db;
        $datas = $db->select(self::$table,"*",[
            "AND" => [
                "code" => $invitecode
            ]
        ]);
        return $datas[0]['uid'];
    }

    static function setInviteCodeUsed($invitecode,$uid){
        global $db;
        $db->update(self::$table,[
            "status" => 0,
            "used_uid" => $uid
        ],[
            "code" => $invitecode
        ]);
    }
}
