<?php
namespace App\Models;
use App\Models\DBConnection;

/**
 * 产品分类关系表
 * author: helicong
 */
class ProductCategoryModels extends Base
{
    protected $_db = 'test_data';
    protected $_table = 'product_category';
    protected $_primary_key = 'id';
    protected $_field = array('id','product_id','category_id','category_title','update_time');

    public function create($params){
        if(empty($params)){
            throw new \Exception('params不能为空');
        }
        $params['update_time'] = time();
        $rs = $this->insert($params);
        return $rs;
    }



    public  function updateTitleByCategory($categoryId, $categoryTitle)
    {
        if(!$categoryId || $categoryTitle === array()){
            throw new \Exception('params is empty');
        }
        $params['update_time']       = time();
        $params['category_title']    = $categoryTitle;
        $where["AND"]["category_id"] = intval($categoryId);
        return $this->update($params, $where);
    }

    /**
     * 获取列表
     */
    public function getList($params = array())
    {
        if(isset($params['product_id'])){
            $where["AND"]["product_id"] = $params['product_id'];
        }
        if(isset($params['category_id'])){
            $where["AND"]["category_id"] = $params['category_id'];
        }
        if(isset($params['category_title'])){
            $where["AND"]["category_title[~]"] = $params['category_title'];
        }

        $where["ORDER"] = 'update_time ASC';

        $result = $this->fetchAll($where,$this->_field);

        $return = array();
        if($result){
            $return = $result;
        }
        return $return;
    }


    public  function deleteByProduct($productId)
    {
        $where["AND"]["product_id"] = intval($productId);
        return $this->delete($where);
    }




    }
