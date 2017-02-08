<?php
/**
 *
 */
class Cola_Router
{
    public $default = array(
        'controller' => 'IndexController',
        'action'     => 'indexAction',
        'args'       => array()
    );

    /**
     * Router rules
     *
     * @var array
     */
    public $rules = array();

    /**
     * Constructor
     *
     */
    public function __construct() {}

    /**
     * Dynamic Match
     *
     * @param string $pathInfo
     * @return array $di
     */
    public function dynamic($pathInfo)
    {
        $di = $this->default;

        if (!preg_match('/^[a-zA-Z\d\/_]+$/', $pathInfo)) {
            return $di;
        }

        $tmp = explode('/', $pathInfo);
        isset($tmp[0]) && $di['controller'] = ucfirst($tmp[0]) . 'Controller';
        isset($tmp[1]) && $di['action'] = "{$tmp[1]}Action";

        return $di;
    }

    /**
     * Match path
     *
     * @param string $path
     * @return boolean
     */
    public function match($pathInfo = null)
    {
        $pathInfo = trim($pathInfo, '/');

        foreach ($this->rules as $regex => $rule) {
            $rule += array('maps' => array(), 'args' => array());
            if (!preg_match($regex, $pathInfo, $matches)) {
                continue;
            }

            if ($rule['maps']) {
                foreach ($rule['maps'] as $pos => $key) {
                    $rule['args'][$key] = urldecode($matches[$pos]);
                }
            }

            return $rule;
        }

        return $this->dynamic($pathInfo);
    }
}