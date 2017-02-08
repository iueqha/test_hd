<?php

/**
 * Define
 */
defined('COLA_DIR') || define('COLA_DIR', dirname(__FILE__));

require COLA_DIR . '/Config.php';


class Cola
{
    /**
     * Singleton instance
     *
     * Marked only as protected to allow extension of the class. To extend,
     * simply override {@link getInstance()}.
     *
     * @var Cola
     */
    protected static $_instance = null;

    /**
     * Object register
     *
     * @var array
     */
    public $reg = array();

    /**
     * Run time config
     *
     * @var Cola_Config
     */
    public $config;

    /**
     * Router
     *
     * @var Cola_Router
     */
    public $router;

    /**
     * Path info
     *
     * @var string
     */
    public $pathInfo;

    /**
     * Dispathc info
     *
     * @var array
     */
    public $dispatchInfo;

    /**
     * Constructor
     *
     */
    protected function __construct()
    {
        $this->config = new Cola_Config(array(
            '_class' => array(
                'Cola_Model'               => COLA_DIR . '/Model.php',
                'Cola_View'                => COLA_DIR . '/View.php',
                'Cola_Controller'          => COLA_DIR . '/Controller.php',
                'Cola_Router'              => COLA_DIR . '/Router.php',
                'Cola_Request'             => COLA_DIR . '/Request.php',
                'Cola_Response'            => COLA_DIR . '/Response.php',
                'Cola_Ext_Validate'        => COLA_DIR . '/Ext/Validate.php',
                'Cola_Exception'           => COLA_DIR . '/Exception.php',
            ),
        ));

        Cola::registerAutoload();
    }

    /**
     * Bootstrap
     *
     * @param mixed $arg string as a file and array as config
     * @return Cola
     */
    public static function boot()
    {
        $config = APP_DIR.'/config/config.inc.php';

        if (is_string($config) && file_exists($config)) {
            include $config;
        }
        if (!is_array($config)) {
            throw new Exception('Boot config must be an array or a php config file with variable $config');
        }

        self::getInstance()->config->merge($config);
        return self::$_instance;
    }

    /**
     * Singleton instance
     *
     * @return Cola
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __invoke()
    {
        return Cola::getInstance();
    }

    /**
     * Set Config
     *
     * @param string $name
     * @param mixed $value
     * @param string $delimiter
     * @return Cola
     */
    public static function setConfig($name, $value, $delimiter = '.')
    {
        self::getInstance()->config->set($name, $value, $delimiter);
        return self::$_instance;
    }

    /**
     * Get Config
     *
     * @return Cola_Config
     */
    public static function getConfig($name, $default = null, $delimiter = '.')
    {
        return self::getInstance()->config->get($name, $default, $delimiter);
    }

    /**
     * Set Registry
     *
     * @param string $name
     * @param mixed $obj
     * @return Cola
     */
    public static function setReg($name, $obj)
    {
        self::getInstance()->reg[$name] = $obj;
        return self::$_instance;
    }

    /**
     * Get Registry
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public static function getReg($name, $default = null)
    {
        $instance = self::getInstance();
        return isset($instance->reg[$name]) ? $instance->reg[$name] : $default;
    }

    /**
     * Common factory pattern constructor
     *
     * @param string $type
     * @param array $config
     * @return Object
     */
    public static function factory($type, $config)
    {
        $adapter = $config['adapter'];
        $class = $type . '_' . ucfirst($adapter);
        return new $class($config);
    }

    /**
     * Load class
     *
     * @param string $class
     * @param string $file
     * @return boolean
     */
    public static function loadClass($class, $file = '')
    {
        if (class_exists($class, false) || interface_exists($class, false)) {
            return true;
        }

        if ((!$file)) {
            $key = "_class.{$class}";
            $file = self::getConfig($key);
        }

        /**
         * auto load Cola class
         */
        if ((!$file) && ('Cola' === substr($class, 0, 4))) {
            $file = dirname(COLA_DIR) . DIRECTORY_SEPARATOR
                  . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
        }

        /**
         * auto load controller class
         */
        if ((!$file) && ('Controller' === substr($class, -10))) {
            $file = self::getConfig('_controllersHome') . "/{$class}.php";
        }

        /**
         * auto load model class
         */
        if ((!$file) && ('Model' === substr($class, -5))) {
            $file = self::getConfig('_modelsHome') . "/{$class}.php";
        }

        if (file_exists($file)) {
            include $file;
        }

        return (class_exists($class, false) || interface_exists($class, false)) || self::psr4($class);
    }

    /**
     * User define class path
     *
     * @param array $classPath
     * @return Cola
     */
    public static function setClassPath($class, $path = '')
    {
        if (!is_array($class)) {
            $class = array($class => $path);
        }

        self::getInstance()->config->merge(array('_class' => $class));

        return self::$_instance;
    }

    /**
     * psr-4 autoloading
     * @param string $class
     * @return boolean
     *
     */
    public static function psr4($class)
    {
        $prefix = $class;
        $psr4 = self::getConfig('_psr4');
        while (false !== ($pos = strrpos($prefix, '\\'))) {
            $prefix = substr($class, 0, $pos);
            $rest = substr($class, $pos + 1);
            if (empty($psr4[$prefix])) continue;
            $file = $psr4[$prefix] . DIRECTORY_SEPARATOR
                  . str_replace('\\', DIRECTORY_SEPARATOR, $rest)
                  . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }
        return false;
    }

    /**
     * Add psr-4 namespace
     *
     */
    public static function addNamespace($prefix, $base)
    {
        $prefix = trim($prefix, '\\') . '\\';
        $base = rtrim($base, DIRECTORY_SEPARATOR);
        $key = $prefix;
        self::setConfig($key, $base);
    }

    /**
     * Get dispatch info
     *
     * @param boolean $init
     * @return array
     */
    public function getDispatchInfo($init = false)
    {
        if ((null === $this->dispatchInfo) && $init) {
            $this->router || ($this->router = new Cola_Router());

            if ($urls = self::getConfig('_urls')) {
                $this->router->rules += $urls;
            }
            $this->pathInfo || $this->pathInfo = (!empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/');

            $this->dispatchInfo = $this->router->match($this->pathInfo);
        }
        return $this->dispatchInfo;
    }
    /**
     * Register autoload function
     *
     * @param string $func
     * @param boolean $enable
     * @return Cola
     */
    public static function registerAutoload($func = 'Cola::loadClass', $enable = true)
    {
        $enable ? spl_autoload_register($func) : spl_autoload_unregister($func);
        return self::$_instance;
    }



    /**
     * Dispatch
     *
     */

    public function dispatch()
    {
        if (!$dispathInfo = $this->getDispatchInfo(true)) {

            throw new Cola_Exception_Dispatch('No dispatch info found');
        }
        extract($dispathInfo);

        if (isset($dispathInfo['file'])) {
            $file = $dispathInfo['file'];
            if (!file_exists($file)) {
                throw new Cola_Exception_Dispatch("Can't find dispatch file:{$file}");
            }
            require_once $file;
        }
        if (isset($dispathInfo['controller'])) {
            $classFile = self::getConfig('_controllersHome') . "/{$dispathInfo['controller']}.php";

            if (!self::loadClass($dispathInfo['controller'], $classFile)) {
                throw new Cola_Exception_Dispatch("Can't load controller:{$dispathInfo['controller']}");
            }
            //支持多级目录修改
            $tmp = explode('/', $dispathInfo['controller']);
            $dispatchInfo['controller'] = end($tmp);
            $controller = new $dispathInfo['controller']();
        }
        if (isset($dispathInfo['action'])) {
            $func = isset($controller) ? array($controller, $dispathInfo['action']) : $dispathInfo['action'];
            if (!is_callable($func, true)) {
                throw new Cola_Exception_Dispatch("Can't dispatch action:{$dispathInfo['action']}");
            }
            call_user_func($func);
        }
    }
}