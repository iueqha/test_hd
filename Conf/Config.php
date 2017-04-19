<?php
namespace Conf;
use \App\Library\Log;
use \App\Library\ErrorNo;
/**
 * @author: helicong@huada-dianqi.cn
 */
class Config
{
    public static function fullConfig() {
        return array(
        'database' => array(
            'mysql' => array(
                'test_data' => array(
                    'master' => array(
						'port'    => 3306,
						'server'  => '192.168.174.175',
						'charset' => 'utf8',
						'username' => 'root',
						'password' => 'root'

					),
                    'slave'  => array(
						'port'    => 3306,
						'server'  => '192.168.174.175',
						'charset' => 'utf8',
						'username' => 'root',
						'password' => 'root'

					)
                )
            )
        ),
        'api' => [
            'asset'     => 'www.test.com',
        ],
        
    );}

    public static function getConfig($path)
    {
        if ($path === null) {
            return false;
        }

        $nodes = explode('/', $path);

        $result = self::fullConfig();

        foreach($nodes as $node) {
            if ($node !== null && isset($result[$node])) {
                $result = $result[$node];
            } else {
                Log::error("Invalid path name, $path");
                return false;
            }
        }

        return $result;
    }

    public static function getDBConfig($dbName, $readOnly = false, $dbType = 'mysql')
    {
        $config = self::fullConfig();
        if (!isset($config['database'][$dbType])) {
            throw new \Exception("The type of $dbType DB not configured", ErrorNo::SVR_MYSQL);
        }

        if (!isset($config['database'][$dbType][$dbName])) {
            throw new \Exception("DB name $dbName not configured", ErrorNo::SVR_MYSQL);
        }

        if ($dbType === 'mongo') {
            return $config['database']['mongo'][$dbName];
        } else {
            $dbConfig = $config['database']['mysql'][$dbName];

            if ($readOnly) {
                if (isset($dbConfig['slave'])) {
                    // one slave
                    if (isset($dbConfig['slave']['server'])) {
                        $result = $dbConfig['slave'];
                    } else {  // multiple slaves
                        $rand_key = array_rand($dbConfig['slave']);
                        $result = $dbConfig['slave'][$rand_key];
                    }
                } else {
                    if (isset($dbConfig['master'])) {
                        $result = $dbConfig['master'];
                    } else {
                        throw new \Exception('Invalid MySQL config', ErrorNo::SVR_MYSQL);
                    }
                }
            } else {
                if (isset($dbConfig['master'])) {
                    $result = $dbConfig['master'];
                } else {
                    throw new \Exception('Invalid MySQL config', ErrorNo::SVR_MYSQL);
                }
            }

            return $result;
        }
    }
}
