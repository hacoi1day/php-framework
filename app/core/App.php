<?php

use app\core\Registry;

require_once(dirname(__FILE__).'/Autoload.php');

/**
 * Class App
 */
class App
{
    private $router;
    private static $controller;
    private static $action;


    function __construct($config)
    {
        new Autoload($config['rootDir']);
        $this->router = new Router($config);

        Registry::getInstance()->config = $config;
    }

    public function run()
    {
        $this->router->run();
    }
}