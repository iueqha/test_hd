<?php
use App\Library\Log;
use App\Library\InterfaceCode;
use App\Library\Util;


class CommonController extends \App\Library\ControllerAbstract
{

    public function addAction(){

    }
    public function editAction(){
        $id     = ($this->input->get('id'))?$this->input->get('id'):'';
        $ret    = array();
        if(!empty($id) && is_numeric($id)){
            $retClass = new App\Models\CommonModels();
            $ret      = $retClass->getInfoById($id);
        }
        $this->getView()->assign('info',$ret);
    }
    public function listAction(){
        $retClass = new App\Models\CommonModels();
        $ret      = $retClass->getTabList();
        $list     = array();
        $count     = 0;
        if(isset($ret['count'])&&$ret['count']>0){
            $list = $ret['list'];
            $count = $ret['count'];
        }
        $this->getView()->assign('list',$list);
        $this->getView()->assign('count',$count);

    }
    public function doAddAction(){
        $this->_setJsonHeader();
        $params    = $this->input->post();
        $retClass  = new App\Models\CommonModels();
        //判断是否有重复的
        $where     = array(
            'OR' => array(
                'name' => $params['name'],
                'key'  => $params['key']
            )
        );
        $isRepeat = $retClass->count($where);
        if($isRepeat){
            echo $this->_echoJson(InterfaceCode::ILLEGAL_PARAMETER,'名称或标识重复，请重新填写',[]);exit;
        }else{
            $ret = $retClass->create($params);
            if($ret){
                echo $this->_echoJson(InterfaceCode::OK);exit;
            }else{
                echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
            }
        }
    }
    public function doEditAction(){
        $this->_setJsonHeader();
        $params = $this->input->post();
        $retClass = new App\Models\CommonModels();
        $ret = $retClass->updateById($params['id'],$params);
        if($ret){
            echo $this->_echoJson(InterfaceCode::OK);exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }
    }
    //删除
    public function doDeleteAction(){
        $id = $this->input->post('id');
        $params['status']    = 0;
        $retClass = new App\Models\CommonModels();
        $ret = $retClass->updateById($id,$params);

        if($ret){
            echo $this->_echoJson(InterfaceCode::OK);exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }
    }



}
