<?php
namespace App\Models;
use App\Models\DBConnection;

/**
 * 产品分类
 * author: helicong
 */
class CategoryModels extends Base
{
    protected $_db = 'test_data';
    protected $_table = 'category';
    protected $_primary_key = 'id';
    protected $_field = array('id','title','pid','update_time');

    public function create($params){
        if(empty($params)){
            throw new \Exception('params不能为空');
        }
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
    public function getList()
    {

        $where["ORDER"] = 'update_time ASC';

        $result = $this->fetchAll($where,$this->_field);

        $return = array();
        if($result){
            $return['list'] = $result;
            $return['count'] = $this->count($where);
        }
        return $return;
    }

    public  function deleteById($id)
    {
        $where["AND"]["id"] = intval($id);
        return $this->delete($where);
    }








    }
