<?php
use App\Library\Log;
use App\Library\InterfaceCode;

class BdmapbonusController extends \App\Library\ControllerAbstract
{
    public function indexAction(){



        $ret = ['code'=>200,'msg'=>'ok'];
        $this->returnApi($ret);

    }
    //根据手机号和身份证后四位验证
    public function driverLoginAction(){
        $cellphone = $this->input->get('cellphone');
        $params = array(
            'name' => 'value',
        );

        $this->getView()->assign('name','value123');

    }
    


}
