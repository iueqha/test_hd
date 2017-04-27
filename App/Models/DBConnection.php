<?php
namespace App\Models;
use App\Library\ErrorNo;

/**
 * author:helicong@huada-dianqi.cn
 */
class DBConnection
{
    private static $dbConfigClass = NULL;
    private static $medooPool = [];

    const MAX_IDLE_TIME = 7200;

    /* Get DB connection
     *
     * @param $dbName - DB name
     * @param $readOnly - connection is used for read only mode
     * @return - an object which represents the connection to a MySQL Server.
     */
    public static function getConnection($dbName, $readOnly = false)
    {
        if (static::$dbConfigClass === null ||
            !method_exists(static::$dbConfigClass, 'getDBConfig')) {
            throw new \Exception('class DBConfig is wrong', ErrorNo::SVR_INVALID_CONFIG);
        }

        $class = static::$dbConfigClass;
        $config = $class::getDBConfig($dbName, $readOnly);
        $key = $config['server'] . ':' . $config['port'];
        if (isset(static::$medooPool[$key]) && static::$medooPool[$key]['medoo'] !== NULL) {
            $medoo = static::$medooPool[$key]['medoo'];
            if (time() - static::MAX_IDLE_TIME >= static::$medooPool[$key]['last_access_time']) {
                $medoo->pdo = NULL;  // close the connection
                $medoo = NULL;
                unset(static::$medooPool[$key]);
                return static::createConnection($dbName, $key, $config);
            }
            if (static::$medooPool[$key]['db_name'] !== $dbName) {
                $medoo->exec("USE {$dbName}");
                static::$medooPool[$key]['db_name'] = $dbName;
            }

            static::$medooPool[$key]['last_access_time'] = time();
            return $medoo;
        } else {
            return static::createConnection($dbName, $key, $config);
        } 
    }
  
    public static function setDBConfigClass($class)
    {   
        if ($class != '') {
            static::$dbConfigClass = $class;
        }
    }   

    private static function createConnection($dbName, $key, $config)
    {  
        $config['database_type'] = 'mysql'; 
        $config['database_name'] = $dbName;
        $config['option'] = [
            \PDO::ATTR_PERSISTENT => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_ORACLE_NULLS => \PDO::NULL_TO_STRING
        ];
        $medoo = new \myMedoo($config);
        static::$medooPool[$key]['medoo'] = $medoo;
        static::$medooPool[$key]['db_name'] = $dbName;
        static::$medooPool[$key]['last_access_time'] = time();

        return $medoo;
    } 
}
