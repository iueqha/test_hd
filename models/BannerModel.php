<?php


class BannerModel extends BaseModel
{
    protected $_db = "test_data";
    protected $_table = "banner";
    protected $_pk = "id";

    public function create($title,$pic,$place){
        $params['title'] = $title;
        $params['pic'] = $pic;
        $params['place'] = $place;
        $params['update_time'] = time();
        $result = $this->insert($params);
        return $result;
    }

}
