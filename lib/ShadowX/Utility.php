<?php
namespace ShadowX;

class Utility {
    //获取随机字符串
    static function getRandomChar($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $char = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            $char .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $char;
    }

    static function ToDateTime($time){
        return date('Y-m-d H:i:s',$time);
    }

    static function getPwdHash($pwd){
        global $salt;
        return hash('sha256',$pwd.$salt);
    }

    static function getSize($value){
        $kb = 1024; $mb = 1024 * 1024; $gb = 1024 * 1024 * 1024;
        $sign = ($value >=0) ? 1 : -1;
        $value = abs($value);
        if ($value > $gb) {
            return round($sign*$value/$gb, 2)." GB";
        }
        else if ($value > $mb) {
            return round($sign*$value/$mb, 2)." MB";
        }
        else if ($value > $kb) {
            return round($sign*$value/$kb, 2)." KB";
        } else {
            return round($sign*$value, 2)." B";
        }
    }

    static function renderTpl($tpl,$data=[]) {
        $content = '';
        $file = fopen($tpl, "r");
        while ($file && !feof($file)) {
            $line = fgets($file);
            while (strpos($line, "{\$") > 0) {
                $index_start = strpos($line, "{\$");
                $index_end = strpos($line, "}");
                $substr = substr($line, $index_start + 2, $index_end - $index_start - 2);
                $line = str_replace("{\$" . $substr . "}", $data[$substr], $line);
            }
            $content .= $line;
        }
        return $content;
    }

    static function geoIP(){
        $ip = "Unknown";
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP")){
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("REMOTE_ADDR")){
            $ip = getenv("REMOTE_ADDR");
        } elseif($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]){
            $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
        } elseif($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]){
            $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
        } elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]){
            $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
        }
        return $ip;
    }

    static function getUptime($t) {
        return intval($t / (3600 * 24)).'天'.date('G',$t)."小时".intval(date('i',$t))."分钟";
    }

    static function ifNull($s1,$s2) {
        return empty($s1) ? $s2 : $s1;
    }

    static function checkHtml($html) {
        $html = stripslashes($html);

        preg_match_all("/<([^<]+)>/is", $html, $ms);
        $searchs[] = '<';
        $replaces[] = '<';
        $searchs[] = '>';
        $replaces[] = '>';
        if($ms[1]) {
            $allowtags = 'img|a|font|div|table|tbody|caption|tr|td|th|br
                        |p|b|strong|i|u|em|span|ol|ul|li|blockquote
                        |object|param|embed';//允许的标签
            $ms[1] = array_unique($ms[1]);
            foreach ($ms[1] as $value) {
                $searchs[] = "<".$value.">";
                $value = shtmlspecialchars($value);
                $value = str_replace(array('/','/*'), array('.','/.'), $value);
                $skipkeys = array(
                    'onabort','onactivate','onafterprint','onafterupdate',
                    'onbeforeactivate','onbeforecopy','onbeforecut',
                    'onbeforedeactivate','onbeforeeditfocus','onbeforepaste',
                    'onbeforeprint','onbeforeunload','onbeforeupdate',
                    'onblur','onbounce','oncellchange','onchange',
                    'onclick','oncontextmenu','oncontrolselect',
                    'oncopy','oncut','ondataavailable',
                    'ondatasetchanged','ondatasetcomplete','ondblclick',
                    'ondeactivate','ondrag','ondragend',
                    'ondragenter','ondragleave','ondragover',
                    'ondragstart','ondrop','onerror','onerrorupdate',
                    'onfilterchange','onfinish','onfocus','onfocusin',
                    'onfocusout','onhelp','onkeydown','onkeypress',
                    'onkeyup','onlayoutcomplete','onload',
                    'onlosecapture','onmousedown','onmouseenter',
                    'onmouseleave','onmousemove','onmouseout',
                    'onmouseover','onmouseup','onmousewheel',
                    'onmove','onmoveend','onmovestart','onpaste',
                    'onpropertychange','onreadystatechange','onreset',
                    'onresize','onresizeend','onresizestart',
                    'onrowenter','onrowexit','onrowsdelete',
                    'onrowsinserted','onscroll','onselect',
                    'onselectionchange','onselectstart','onstart',
                    'onstop','onsubmit','onunload','javascript',
                    'script','eval','behaviour','expression',
                    'style','class'
                );
                $skipstr = implode('|', $skipkeys);
                $value = preg_replace(array("/($skipstr)/i"), '.', $value);
                if(!preg_match("/^[/|s]?($allowtags)(s+|$)/is", $value)) {
                    $value = '';
                }
                $replaces[] = empty($value)?'':"<".str_replace('"', '"', $value).">";
            }
        }
        $html = str_replace($searchs, $replaces, $html);

        $html = addslashes($html);
        return $html;
    }
}