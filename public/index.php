<?php
require '../init.php';
define('APP_PATH', ROOT_PATH . 'App/');

// 定义yaf应用配置文件
define('APP_INI',  ROOT_PATH . "Conf/App.ini");

ini_set('yaf.library', ROOT_PATH . 'library/');

App\Library\Asset::config(['domain' => \Conf\Config::getConfig('api/asset')]);

$application = new Yaf_Application(APP_INI);
//$application->getDispatcher()->catchException(true);
$application->bootstrap()->run();
