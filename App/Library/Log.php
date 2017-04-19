<?php
namespace App\Library;

class Log {
    const LEVEL_EMERGENCY = 0;
    const LEVEL_ALERT     = 1;
    const LEVEL_CRITICAL  = 2;
    const LEVEL_ERROR     = 3;
    const LEVEL_WARNING   = 4;
    const LEVEL_NOTICE    = 5;
    const LEVEL_INFO      = 6;
    const LEVEL_DEBUG     = 7;

    public static function emergency($message)
    {
        self::log(self::LEVEL_EMERGENCY, $message);
    }

    public static function alert($message)
    {
        self::log(self::LEVEL_ALERT, $message);
    }

    public static function critical($message)
    {
        self::log(self::LEVEL_CRITICAL, $message);
    }

    public static function error($message)
    {
        self::log(self::LEVEL_ERROR, $message);
    }

    public static function warning($message)
    {
        self::log(self::LEVEL_WARNING, $message);
    }
    public static function notice($message)
    {
        self::log(self::LEVEL_NOTICE, $message);
    }
    public static function info($message)
    {
        self::log(self::LEVEL_INFO, $message);
    }

    public static function debug($message)
    {
        self::log(self::LEVEL_DEBUG, $message);
    }

    public static function log($level, $message)
    {
        if (self::$logLevel >= $level) {
            if (self::$sapiType === null) {
                self::$sapiType = php_sapi_name();
            }

            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);



            $full_msg = self::$errorString[$level] . ' - pid: ' . self::$pid .
                ", file: {$backtrace[1]['file']}, line: {$backtrace[1]['line']}, $message";
            if (self::$sapiType === 'cli') {
                $full_msg = date('[Y-m-d H:i:s] ') . $full_msg;
                $full_msg = date('[Y-m-d H:i:s] ') . $full_msg;
            }
            error_log($full_msg);
        }
    }
    public static function setLogLevel($level)
    {
        self::$logLevel = $level;
    }

    private static $errorString = array(
        'EMERGENCY',
        'ALERT',
        'CRITICAL',
        'ERROR',
        'WARNING',
        'NOTICE',
        'INFO',
        'DEBUG'
    );

    private static $logLevel = self::LEVEL_ERROR;
    private static $sapiType = null;
    private static $pid = -1;
}
