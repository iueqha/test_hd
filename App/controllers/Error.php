<?php
use App\Library\ControllerAbstract;

class ErrorController extends Yaf_Controller_Abstract
{
    public function errorAction($exception){
        Yaf_Dispatcher::getInstance()->disableView();
        /* error occurs */
        echo 'NOT FOUND';
    }

}

