<?php
use App\Library\Log;
use App\Library\InterfaceCode;
use App\Library\Util;


class ProductController extends \App\Library\ControllerAbstract
{

    public function addAction(){

    }
    public function editAction(){
        $id     = ($this->input->get('id'))?$this->input->get('id'):'';
        $ret    = array();
        if(!empty($id) && is_numeric($id)){
            $retClass = new App\Models\ProductModels();
            $ret      = $retClass->getInfoById($id);
        }
        $this->getView()->assign('info',$ret);
    }
    public function listAction(){
        $p            = ($this->input->get('p'))?$this->input->get('p'):1;
        $searchParam  = array(
            'id'     => ($this->input->get('searchId'))?$this->input->get('searchId'):'',
            'title'  => ($this->input->get('searchTitle'))?$this->input->get('searchTitle'):''
        );
        $pageSize = 20;
        $retClass = new App\Models\ProductModels();
        $ret      = $retClass->getList($p,$pageSize,$searchParam);
        $list     = array();
        $count     = 0;
        $pageCount = 1;
        if(isset($ret['count'])&&$ret['count']>0){
            $list = $ret['list'];
            $count = $ret['count'];
            $pageCount = ceil($count/$pageSize);
        }
        $this->getView()->assign('list',$list);
        $this->getView()->assign('count',$count);
        $this->getView()->assign('pageCount',$pageCount);
        $this->getView()->assign('nowPage',$p);
        $this->getView()->assign('searchId',$searchParam['id']);
        $this->getView()->assign('searchTitle',$searchParam['title']);

    }
    public function doAddAction(){
        $this->_setJsonHeader();
        $params = $this->input->post();
        $retClass = new App\Models\ProductModels();
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
        $retClass = new App\Models\ProductModels();
        $ret = $retClass->updateById($params['id'],$params);
        if($ret){
            echo $this->_echoJson(InterfaceCode::OK);exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }
    }
    //删除管理员
    public function doDeleteAction(){
        $id = $this->input->post('id');
        $params['status']    = 0;
        $retClass = new App\Models\ProductModels();
        $ret = $retClass->updateById($id,$params);

        if($ret){
            echo $this->_echoJson(InterfaceCode::OK);exit;
        }else{
            echo $this->_echoJson(InterfaceCode::DB_ERROR);exit;
        }
    }



}
