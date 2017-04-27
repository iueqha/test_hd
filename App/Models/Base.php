<?php
namespace App\Models;
use App\Library\Auth;

/**
 * base model
 * @author: helicong@huada-dianqi.cn
 * 2015-07-05
 */

class Base {
    protected $_medoo;
    protected $_db;
    protected $_table;
    protected $_primary_key;

    protected $_operatorId=0;

    protected $_sensitiveField= array('update_time','updater_id','creator_id');

    const MASTER = false; //master database
    const SLAVE = true;   //slave  database

    const STATUS_OK = 1;
    const STATUS_DELETED = 14;

    public function __construct(){
        DBConnection::setDBConfigClass('Conf\Config');
    }

    /**
     * fetch one row with all fields by primary key
     * @param int $id primary key value
     * @return mixed
     *     @example array('key'=>value) when succeed 
     *     @example false when data not exists or fail 
     */
    public function find($id) {
        $this->_medoo = DBConnection::getConnection($this->_db, self::SLAVE);
        return $this->_medoo->get($this->_table, '*', [$this->_primary_key => $id]);
    }

    /**
     * fetch one row with given fields by condition
     *
     * @param array $where   condition
     * @param mixed $fields  string/array
     * @return mixed 
     *     @example array('key'=>value) when succeed 
     *     @example false when data not exists or fail 
     */
    public function fetchRow($where, $fields = '*') {
        $this->_medoo = DBConnection::getConnection($this->_db, self::SLAVE);
        return $this->_medoo->get($this->_table, $fields, $where);
    }

    /**
     * fetch all rows with given fields by condition
     *
     * @param array $where   condition
     * @param mixed $fields  string/array
     * @return mixed  
     *     @example [['key'=>value1],['key'=>value2]] when succeed
     *     @example array() when data not exists
     *     @example false when query fail
     */
    public function fetchAll($where, $fields = '*') {
        $this->_medoo = DBConnection::getConnection($this->_db, self::SLAVE);
        return $this->_medoo->select($this->_table, $fields, $where);
    }

    /**
     * insert data.support batch insert,but carry out with multi sql statements,
     * so batchInsert method is recommended with batch insert.
     *
     * @param array $data 
     *     @example insert one row once:['key' => value]
     *     @example insert multi rows once: [['key'=>value1],['key'=>value2]]
     *
     * @return mixed  
     *     @example int reutrn last insert id if succeed,0 when fail 
     *     @example array the return array dimension is equal with the $data
     *         [1(last insert id), 0(fail)]     
     */
    public function insert($data) {
        $this->_medoo = DBConnection::getConnection($this->_db, self::MASTER);
        return $this->_medoo->insert($this->_table, $data);
    }

    /**
     * batch insert with one sql statement
     *
     * @param array $data
     *     @example insert multi rows once: [['key'=>value1],['key'=>value2]]
     *
     * @return mixed
     *     @example array  return the inserted ids,the return array dimension 
     *     is equal with the $data, [1, 2]
     *     @example false  when fail
     */
    public function batchInsert($datas) {
        $this->_medoo = DBConnection::getConnection($this->_db, self::MASTER);
        return $this->_medoo->batchInsert($this->_table, $datas);
    }

    /**
     * @param array $data
     * @param array $where
     * @return mixed  return the number of affected rows when succeed,false when fail 
     */
    public function update($data, $where) {
        $this->_medoo = DBConnection::getConnection($this->_db, self::MASTER);
        return $this->_medoo->update($this->_table, $data, $where);
    }

    /**
     * @param array $where
     * @return mixed  return the number of affected rows when succeed,false when fail 
     */ 
    public function delete($where) {
        $this->_medoo = DBConnection::getConnection($this->_db, self::MASTER);
        return $this->_medoo->delete($this->_table, $where);
    }

    /**
     * use PDO::query()
     *
     * @param string $sql  @example 'select * from activity;'
     * @return mixed  return object PDOStatement when succeed,false when fail 
     */
    public function query($sql) {
        $this->_medoo = DBConnection::getConnection($this->_db, self::MASTER);
        return $this->_medoo->query($sql);
    }

    /**
     * return last query sql
     */
    public function lastQuery() {
        return $this->_medoo->last_query();
    }

    public function begin() {
        if (empty($this->_medoo)) {
            $this->_medoo = DBConnection::getConnection($this->_db, self::MASTER);
        }
        $this->_medoo->pdo->beginTransaction();
    }   

    public function commit() {
        if (empty($this->_medoo)) {
            $this->_medoo = DBConnection::getConnection($this->_db, self::MASTER);
        }
        if ( ! empty($this->_medoo) && $this->_medoo->pdo->inTransaction()) {
            $this->_medoo->pdo->commit();
        }
    }   

    public function rollback() {
        if (empty($this->_medoo)) {
            $this->_medoo = DBConnection::getConnection($this->_db, self::MASTER);
        }
        if ( ! empty($this->_medoo) && $this->_medoo->pdo->inTransaction()) {
            $this->_medoo->pdo->rollback();
        }
    }

    public function getErrors(){
        return $this->_medoo->error();
    }

    public function count($where){
        $this->_medoo = DBConnection::getConnection($this->_db, self::SLAVE);
        return $this->_medoo->count($this->_table,$where);
    }

    /*
    public function __destruct() {
        if ( ! empty($this->_medoo) && $this->_medoo->pdo->inTransaction()) {
            $this->_medoo->pdo->commit();
        }
    }
    */

    public function getPrimaryKeyField(){
        return $this->_primary_key;
    }

    /**
     * 获取当前表信息
     * @return mixed
     */
    protected function getFields(){
        $return =array();
        $fields = $this->query('show columns from '.$this->_table);
        if($fields){
            foreach($fields->fetchAll() as $field){
                $return[$field['Field']] = (strpos($field['Type'],'int') !== false)?'int': 'string';
            }
        }
        return $return;
    }

    public function getFiledLableMap(){
        $return =array();
        $fields = $this->query('show full FIELDS from '.$this->_table);
        if($fields){
            foreach($fields->fetchAll() as $field) {
                if($field['Field'] != $this->getPrimaryKeyField()){
                    if(in_array($field['Field'],array('ctime','create_time'))){
                        $return[$field['Field']] = '创建时间';
                    }else{
                        $return[$field['Field']] = $field['Comment'];
                    }
                }else{
                    $return[$this->getPrimaryKeyField()] = '记录id';
                }
            }
        }
        return $return;
    }


    public function filterDatas(array $data){
        $tableFields  = $this->getFields();
        $return = array();
        if($tableFields){
            $tableFieldsKeys = array_keys($tableFields);
            foreach($data as $key=>$value){
                if(in_array($key,$tableFieldsKeys)){
                    $return[$key]= ($tableFields[$key] == 'int') ? intval($value) : $value;
                }
            }
        }
        return $return;
    }

    public function filteringSensitiveField(array $data,array $fields=array()){
        if(!$data)return array();
        $fields =array_merge($this->_sensitiveField,$fields);
        if($fields !==array()){
            foreach($fields as $field){
                if(isset($data[$field])){
                    unset($data[$field]);
                }
            }
        }
        return $data;
    }


    public function getTableName(){
        return $this->_table;
    }

    public function getOperatorId(){
        return Auth::getIdentity();
    }
    
    public function getUpdaterArr(){
        return array(
            'updater_id'=>$this->getOperatorId(),
            'update_time'=>time()
        );
    }

    public function getCreatorArr(){
        $creatorArr = array(
            'creator_id'=>$this->getOperatorId(),
            'create_time'=>time()
        );
        return $creatorArr;//array_merge($this->getUpdaterArr(),$creatorArr);
    }
 }

