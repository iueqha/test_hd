<?php

class BaseModel extends Cola_Model
{

    public function __construct(){
        $this->__set('_dbConfig',Cola::getConfig("_db_config"));
    }
    public static function getInstance()
    {
        static $_instance = NULL;
        if (empty($_instance)) {
            $_instance = new static();
        }
        
        return $_instance;
    }






}
