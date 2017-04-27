<?php
namespace App\Library;

class Util {
    /** 
    * 是否是SSL连接
    */
    public static function isSsl() {
        return isset($_SERVER['HTTPS']) || isset($_SERVER['HTTP_X_FROM_SSL']);
    }
    
    /**
    * 得到当前URL
    */
    public static function getCurrentUrl($forceSecure = false) {
        $requestUri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_UNSAFE_RAW);
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $schema = (self::isSsl()) || $forceSecure ? "https" : "http";
        $port = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : '';
        $port = ($port == '80' && $schema == "http") ||
                    ($port == "443" && $schema == "https") || $forceSecure ? "" : (":" . $port);
        return $schema . "://" . $host . $port . $requestUri;
    }
    
    /**
    * 获取js的签名信息
    */
    public static function getJsSign($url = null){
        if(!$url){
            if(isset($_SERVER['HTTP_X_FORWARDED_HOST'])){
                $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
            }else{
                $host = $_SERVER['HTTP_HOST'];
            }
            $url = self::getCurrentUrl();
        }
        return self::getWeixinSignature($url);
    }
    
    /**
    * 获得随机字符串
    * @return string
    */
    public static function getRandom() {
        $random = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        $len = 16;

        $min = 0;
        $max = strlen($random) - 1;

        $str = "";

        for($i = 0 ; $i < $len ; $i++) {
            $str .= $random[mt_rand($min, $max)];
        }

        return $str;
    }

    public static function setCookie($name,$value,$expire=86400,$path='/',$domin='.huada-dianqi.cn',$secure=false,$httpOnly=false){
        $domin = is_null(static::getCookieDomin())?$domin:static::getCookieDomin();
        setcookie($name,$value,time()+$expire,$path,$domin,$secure,$httpOnly);
    }

    public static function getCookieDomin(){
        $domin = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'';
        if(!$domin){
            return null;
        }
        $dominArr = explode('.',$domin);
        $dominLen = count($dominArr);
        return '.'.$dominArr[$dominLen-2].'.'.$dominArr[$dominLen-1];
    }


}
