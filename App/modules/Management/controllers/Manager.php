<?php
use App\Library\Log;
use App\Library\InterfaceCode;
use App\Library\Util;


class ManagerController extends \App\Library\ControllerAbstract
{
    protected $_commonPassword = 'He12345687';
    public function listAction(){
        $retClass = new App\Models\ManagerModels();
        $ret      = $retClass->getList(1,20);
        $list     = array();
        $count    = 0;
        if($ret && $ret['count']>0){
            $list = $ret['list'];
            $count = $ret['count'];
        }
        $this->getView()->assign('list',$list);
        $this->getView()->assign('count',$count);

    }
    //添加
    public function doAddAction(){
        $account = $this->input->post('account');
        $password = $this->input->post('password');
        //获取加密后的密码
        $newPass = $this->encrypPassword($password);
        $params['account']  = $account;
        $params['password'] = $newPass[1];
        $params['encrypt_key'] = $newPass[0];
        $retClass = new App\Models\ManagerModels();
        $ret = $retClass->create($params);
        if($ret){
            echo $this->_echoJson(InterfaceCode::OK);exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }

    }
    //删除管理员
    public function delManagerAction(){
        $id = $this->input->post('id');
        $params['status']    = 0;
        $retClass = new App\Models\ManagerModels();
        $ret = $retClass->updateById($id,$params);

        if($ret){
            echo $this->_echoJson(InterfaceCode::OK);exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }
    }
    //重置密码
    public function resetPasswordAction(){
        $id = $this->input->post('id');
        $password = $this->_commonPassword;
        //获取加密后的密码
        $newPass = $this->encrypPassword($password);
        $params['password']    = $newPass[1];
        $params['encrypt_key'] = $newPass[0];
        $retClass = new App\Models\ManagerModels();
        $ret = $retClass->updateById($id,$params);

        if($ret){
            echo $this->_echoJson(InterfaceCode::OK,'',array('password'=>$password));exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }
    }

    protected function encrypPassword($password,$encrypt_key = ''){
        if(empty($encrypt_key)){
            //获取随机数
            $encrypt_key = Util::getRandom();
        }
        $newPassword = md5($password.md5($encrypt_key));

        $returnArr = array();
        $returnArr[0] = $encrypt_key;
        $returnArr[1] = $newPassword;
        return $returnArr;

    }



}
