<?php
namespace App\Models;
use App\Models\DBConnection;

/**
 * 留言
 * author: helicong
 */
class MessageModels extends Base
{
    protected $_db = 'test_data';
    protected $_table = 'message';
    protected $_primary_key = 'id';
    protected $_field = array('id','name','cellphone','phone','info','ip','create_time','is_read','desc','update_time');

    public function create($params){
        if(empty($params)){
            throw new \Exception('params不能为空');
        }
        $params['create_time'] = time();
        $params['update_time'] = time();
        $rs = $this->insert($params);
        return $rs;
    }

    public function getInfoById($id){
        if(empty($id)){
            throw new \Exception('id不能为空');
        }
        $where['AND']['id'] = $id;
        $where['LIMIT'] = 1;
        $rs = $this->fetchAll($where,$this->_field);
        if($rs){
            return $rs[0];
        }else{
            return array();
        }
    }

    public  function updateById($id, $params)
    {
        if(!$id || $params === array()){
            throw new \Exception('params is empty');
        }
        $params['update_time'] = time();
        $where["AND"]["id"] = intval($id);
        return $this->update($params, $where);
    }

    /**
     * 获取列表
     */
    public function getList($page,$pageSize)
    {

        $where["ORDER"] = 'update_time DESC';

        //分页
        $offset = ($page-1)*$pageSize;
        $where["LIMIT"]=array($offset,$pageSize);

        $result = $this->fetchAll($where,$this->_field);

        $return = array();
        if($result){
            $return['list'] = $result;
            unset($where['LIMIT']);
            $return['count'] = $this->count($where);
        }
        return $return;
    }








    }
