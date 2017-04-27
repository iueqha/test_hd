<?php

class Bootstrap extends Yaf_Bootstrap_Abstract{
    public function _initPlugin(Yaf_Dispatcher $dispatcher) {
        /* register a plugin */
        $dispatcher->registerPlugin(new SmartyPlugin());
    }  
}
