<?php
use App\Library\Log;
use App\Library\InterfaceCode;
use App\Library\Util;


class CategoryController extends \App\Library\ControllerAbstract
{
    public function listAction(){

    }
    public function getlistAction(){
        $this->_setJsonHeader();
        $retClass = new App\Models\CategoryModels();
        $ret      = $retClass->getList();
        $list     = array();
        if(isset($ret['count'])&&$ret['count']>0){
            $list  = $ret['list'];
        }
        echo $this->_echoJson(InterfaceCode::OK,'ok',$list);exit;

    }
    public function doAddAction(){
        $this->_setJsonHeader();
        $params = $this->input->post();
        $retClass = new App\Models\CategoryModels();
        $ret = $retClass->create($params);
        if($ret){
            echo $this->_echoJson(InterfaceCode::OK);exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }
    }
    public function doEditAction(){
        $this->_setJsonHeader();
        $params = $this->input->post();
        $retClass = new App\Models\CategoryModels();
        $ret = $retClass->updateById($params['id'],$params);
        if($ret){
            echo $this->_echoJson(InterfaceCode::OK);exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }
    }
    //删除管理员
    public function doDeleteAction(){
        $this->_setJsonHeader();
        $id = $this->input->post('id');
        $retClass = new App\Models\CategoryModels();
        $ret = $retClass->deleteById($id);

        if($ret){
            echo $this->_echoJson(InterfaceCode::OK);exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }
    }



}
