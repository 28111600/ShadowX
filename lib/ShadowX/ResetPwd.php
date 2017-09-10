<?php
namespace ShadowX;

class ResetPwd {
    private static $table = "ss_reset_pwd";

    static function addResetCode($uid){
        global $db;
        $expire = time() + 3600 * 24;
        $code = md5(time()).md5($uid);
        $code = sha1($code);
        $db->insert(static::$table,[
            "expire" => $expire,
            "uid" => $uid,
            "code" => $code
        ]);
        return $code;
    }

    static function isResetCodeValid($uid,$code){
        global $db;
        return $db->has(static::$table,[
            "code" => $code,
            "uid" => $uid,
            "expire[>]" => time()
        ]);
    }

    static function deleteResetCode($code){
        global $db;
        return $db->delete(static::$table,[
            "code" => $code
        ]);
    }

    static function getCount($uid){
        global $db;
        return $db->count(static::$table,[
            "AND" => [
                "uid" => $uid,
                "expire[>]" => time()
            ]
        ]);
    }
}
