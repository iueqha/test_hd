<?php
class SmartyPlugin extends Yaf_Plugin_Abstract
{
    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $smartyConfig = Yaf_Application::app()->getConfig()->smarty->toArray();
        $moduleName = $request->getModuleName();
        $smartyConfig['template_dir'] = $smartyConfig['template_dir'] . $moduleName;
        $smarty = new Smarty_Adapter(NULL, $smartyConfig);
        Yaf_Dispatcher::getInstance()->setView($smarty);
    }
}
