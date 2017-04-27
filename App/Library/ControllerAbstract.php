<?php
namespace App\Library;
use App\Library\CI\Input;

class ControllerAbstract extends \Yaf_Controller_Abstract
{
    protected $_jsonpCallback = null;

    protected $_whiteIpList = array(

    );

    private $_notLimitModules = array(
        'activity',
//        'index',
        'prize'
    );

    public function init() {
        $this->input = new Input();
        $callback = $this->input->get('callback',true);
        $this->_jsonpCallback = $callback ? $callback : null;
        $moduleName  = $this->getRequest()->getModuleName();
        // 公共页面部分
        $this->view = $this->getView();
        $this->view->assign('SHIVE', APP_PATH . 'views');


    }

    protected function _setJsonHeader($isAllowOrigin=false){
        header("Content-Type: application/json");
        \Yaf_Dispatcher::getInstance()->disableView();
        if($isAllowOrigin){
            $this->_setAllowOrigin();
        }
    }

    protected function _setAllowOrigin(){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
    }

    /**
     * @param $code
     * @param array $result
     * @param string $msg
     * @return string
     */
    protected function _echoJson($code,$msg='',$result=array()){ #result
        $return =array(
            'code'   => $code,
            'msg'    => \App\Library\InterfaceCode::getMeaning($code),
        );
        if(!empty($msg)){
            $return['msg']=$msg;
        }
        if(!empty($result)){
            $return['result']=$result;
        }
        if($this->_jsonpCallback){
            return $this->_jsonpCallback.'('.json_encode($return).')';
        }
        return json_encode($return);
    }



    function getClientIp()
    {
        foreach (array(
                     'HTTP_CLIENT_IP',
                     'HTTP_X_FORWARDED_FOR',
                     'HTTP_X_FORWARDED',
                     'HTTP_X_CLUSTER_CLIENT_IP',
                     'HTTP_FORWARDED_FOR',
                     'HTTP_FORWARDED',
                     'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    //会过滤掉保留地址和私有地址段的IP，例如 127.0.0.1会被过滤
                    //也可以修改成正则验证IP
                    if ((bool) filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
        }
        return null;
    }


}

