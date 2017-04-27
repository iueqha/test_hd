<?php
namespace App\Library;

class Asset {

    static protected $_instance;

    protected static $_version;

    static protected $_config = array(
            'domain' => 'www.test.com',
            'https_domain' => 'www.test.com',
            'prefix' => 'i',
            'mirrors' => 3,
            );

    static public function config($config = array()) {
        self::$_config = $config + self::$_config;
    }

    public static function setVersion($ver = 0) {
        $oldVer = null;
        $key = __CLASS__ . "_version";
        if(class_exists("Yac")) {
            $yac = new \Yac("FE");
            $oldVer = $yac->get($key);
            if($ver != 0) {
                $ver = $ver - $ver % 120;
                $yac->set($key, $ver);
            }
        } else if(function_exists("apc_fetch")) {
            $oldVer = apc_fetch($key);
            if($ver != 0) {
                $ver = $ver - $ver % 120;
                apc_store($key, $ver);
            }
        }
        return $oldVer;
    }

    protected static function _getVersion() {
        $ver = self::$_version;
        if(!$ver) {
            $key = __CLASS__ . "_version";
            if(class_exists("Yac")) {
                $yac = new \Yac("FE");
                $ver = $yac->get($key);
                if(!$ver) {
                    $ver = time();
                    $ver = $ver - $ver % 120;
                    $yac->set($key, $ver);
                }
            } else if(function_exists("apc_fetch")) {
                $ver = apc_fetch($key);
                if(!$ver) {
                    $ver = time();
                    $ver = $ver - $ver % 120;
                    apc_add($key);
                }   
            }
            self::$_version = $ver;
        }   
        return $ver;
    } 

    static public function getUrl($path) {
        $ver = self::_getVersion();
        $path = $path ? "$path?$ver" : "";
        if(Util::isSsl()) {
            $url = "https://" . self::$_config['https_domain'] . "/$path"; 
        } else {
            $num = (sprintf('%u', crc32($path)) % self::$_config['mirrors']) + 1;
            $domain = self::$_config['domain'];
            $url = "http://i$num.$domain/$path";
        }
        return $url;
    }

    static public function getInstance() {
        if(!is_object(self::$_instance)) 
            self::$_instance = new self();
        return self::$_instance;
    }
}
