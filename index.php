<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

date_default_timezone_set('Asia/Shanghai');
defined('APP_DIR') || define('APP_DIR', dirname(__FILE__));
require 'Cola/Cola.php';

$cola = Cola::getInstance();

$cola->boot()->dispatch();

