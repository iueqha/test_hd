<?php
namespace App\Library;

class InterfaceCode
{
    const OK = 200;
    const ILLEGAL_PARAMETER = 400;
    //const UNAUTHORIZED = 401;
    const FORBIDDEN = 401;
    const NOT_FOUND = 404;
    const SERVER_ERROR = 500;
    const DB_ERROR = 503;
    const NOT_LOGIN = 403;
    const SEND_OUT = 406;
    const RECEIVED = 409;
    const NOT_INVATE = 405;
    const TIME_NOT_START = 504;
    const TIME_END =505;
    const REGIST_ERROR=506;
    const FAST_FREQUENCY = 507;
    const SEND_TO_NOKNOW = 508;
    const PROHIBITION_OF_SHARING = 509;
    const WAIT_SEND = 510;

    public static function getMeaning($code = NULL) {
        $meaning = array(
                static::OK => '成功',
                static::ILLEGAL_PARAMETER => '参数不合法',
                static::FORBIDDEN => '禁止访问',
                static::NOT_FOUND => '活动未找到',
                static::SERVER_ERROR => '服务器正在偷懒，请稍后重试',
                static::DB_ERROR => '服务器正在偷懒，请稍后重试',
                static::NOT_LOGIN=>'未登录',
                static::SEND_OUT=>'该券已被领光',
                static::RECEIVED=>'已经领取过了',
                static::NOT_INVATE=>'不是受邀用户',
                static::TIME_NOT_START =>'活动未开始',
                static::TIME_END=>'活动已下线',
                static::REGIST_ERROR=>'注册失败',
                static::FAST_FREQUENCY=>'访问频率过快',
                static::SEND_TO_NOKNOW=>'送券方式不明',
                static::PROHIBITION_OF_SHARING =>'禁止分享',
                static::WAIT_SEND => '等待中'

        );

        if (empty($code)) {
            return $meaning;
        } else {
            return $meaning[$code];    
        }
    }
}
