<?php
$config = array(
    '_apisHome'      => 'apis',
    '_modelsHome'      => 'models',
    '_controllersHome' => 'controllers',
    '_viewsHome'       => 'views',
    '_widgetsHome'     => 'widgets',
    '_urls' => array(
        '/^view\/?(\d+)?$/' => array(
            'controller' => 'IndexController',
            'action' => 'viewAction',
            'maps' => array(
                1 => 'id'
            ),
            'defaults' => array(
                'id' => 9527
            )
        ),

        '/^v-?(\d+)?$/' => array(
            'controller' => 'IndexController',
            'action' => 'viewAction',
            'maps' => array(
                1 => 'id'
            ),
            'defaults' => array(
                'id' => 9527
            )
        )
    ),
    "_db_config" => array(
        "test_data" => array(
            "master" => array(
                'adapter' => 'Pdo_Mysql',
                'host' => '192.168.174.175',
                'port' => 3306,
                'user' => 'root',
                'password' => 'root',
                'database' => 'test_data',
                'charset' => 'utf8',
                'persitent' => false
            ),
            "slave" => array(
                'adapter' => 'Pdo_Mysql',
                'host' => '192.168.174.175',
                'port' => 3306,
                'user' => 'root',
                'password' => 'root',
                'database' => 'test_data',
                'charset' => 'utf8',
                'persitent' => false
            ),
        )
    ),
);

