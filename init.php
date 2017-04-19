<?php
define('ROOT_PATH', str_replace('\\','/',realpath(__DIR__)) . '/');

spl_autoload_register(function ($class) {
    $file = str_replace('\\', '/', $class).'.php';
    //echo $file.'1</br>';
    if (is_file(ROOT_PATH . $file)) {
        require_once ROOT_PATH . $file;
    } elseif (is_file(ROOT_PATH . 'library/' . $file)) {
        require_once ROOT_PATH . 'library/' . $file; 
    }else{
        $file = strtolower($file);
        if (is_file(ROOT_PATH . 'library/Smarty/libs/sysplugins/' . $file)) {
            require_once ROOT_PATH . 'library/Smarty/libs/sysplugins/' . $file;
        }
    }
});
