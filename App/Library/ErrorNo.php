<?php
namespace App\Library;
class ErrorNo
{
    /**
     * @vars 200-299 成功
     */
    const OK = 200; //成功

    /**
     * @vars 400-499 客户端错误
     */
    const REQ_AUTH_REQUIRED    = 401; //未授权
    const REQ_FORBIDDEN        = 403; //禁止访问
    const REQ_NOT_FOUND        = 404; //类名或函数未找到
    const REQ_INVALID_ARGUMENT = 451; //请求中参数不对

    /**
     * @vars 500-599 服务器端错误
     */
    const SVR_INTERNAL        = 500; //内部错误
    const SVR_MYSQL           = 551; //mysql错误
    const SVR_INVALID_CONFIG  = 552; //服务器配置错误
    const SVR_INVALID_SERVICE = 553; //服务名错误

    /**
     * @vars 10000-10999 应用的通用错误
     */
    const APP_OPERATION_NOT_ALLOWED = 10000; //操作无法进行，例如取消不存在的订单

    /**
     * @vars 11000-11999 司机模块错误
     */

    /**
     * @vars 12000-12999 风控模块错误
     */
    const RC_UNPAID_WITHOUT_CREDIT_CARD                = 12001;
    const RC_UNPAID_WITH_CREDIT_CARD                   = 12002;
    const RC_RENT_DAILY                                = 12003;
    const RC_RENT_HALF_DAY                             = 12004;
    const RC_PAY_DIRECTLY                              = 12005;
    const RC_BLACK_LIST                                = 12006;
    const RC_RENT_HOTLINE                              = 12007;
    const RC_LOGICAL_ERROR                             = 12008;
    const RC_FREEZE_SYSTEM                             = 12010;
    const RC_FREEZE_MANUALLY                           = 12011;
    const RC_CANCEL_DRIVER_SELECTION_10_TIMES          = 12012;
    const RC_CANCEL_ORDER_4_TIMES                      = 12013;
    const RC_USER_STATUS_INVALID                       = 12014;
    const RC_CORPORATE_FREEZE                          = 12020;
    const RC_CORPORATE_USER_TIME_RESTRICTED            = 12021;
    const RC_CORPORATE_USER_PERSONAL_ACCOUNT_DEFICIT   = 12022;
    const RC_CORPORATE_USER_EXPIRED                    = 12023;
    const RC_CORPORATE_USER_DEPARTMENT_ACCOUNT_DEFICIT = 12024;
    const RC_CORPORATE_ACCOUNT_INVALID                 = 12025;
    const RC_ABNORMAL_ORDER                            = 12030;
    const RC_RENT_TIME                                 = 12040;
    const RC_TO_AIRPORT                                = 12041;
    const RC_FROM_AIRPORT                              = 12042;

    /**
     *
     * @vars 13000-13999设备中心错误号
     */
    const DC_BLACK_DEVICE_EEXSIST                      = 13001;
    const DC_RECORD_NOT_EXIST                          = 13002;

    /**
     *
     * @vars 14001-14012配置中心API错误号
     */
    const PUBLISH_USER_AUTHERTICATION_FAIL             = 14001;
    const PUBLISH_ENV_AUTHERTICATION_FAIL              = 14002;
    const PUBLISH_APP_AUTHERTICATION_FAIL              = 14003;
    const PUBLISH_SIGNATURE_AUTHERTICATION_FAIL        = 14004;
    const PUBLISH_CHECK_NULLABLE_FAIL                  = 14005;
    const PUBLISH_UPDATE_STRING_ERROR                  = 14006;
    const PUBLISH_UPDATE_MAPLIST_ERROR                 = 14007;
    const PUBLISH_UPDATE_GLOBAL_CONF_ERROR             = 14008;
    const PUBLISH_UPDATE_ENV_CONF_ERROR                = 14009;
    const PUBLISH_UPDATE_CURRENT_CONF_ERROR            = 14010;
    const PUBLISH_CONFLICT_ERROR                       = 14011;
    const PUBLISH_CASCADE_ERROR                        = 14012;
    const PUBLISH_CONFIGNAME_ERROR                     = 14013;
    const PUBLISH_CONFIGTYPE_ERROR                     = 14014;
    const PUBLISH_INSERTTEMP_ERROR                     = 14015;
    const PUBLISH_TIMEOUT_ERROR                        = 14016;
    const PUBLISH_UPDATE_ENV_VERSION_ERROR             = 14017;
    const PUBLISH_CONTENT_EMPTY_ERROR                  = 14018;
}