<?php
//chạy đầu tiên, phân tích các URL
use app\core\AppException;
use app\core\Registry;

/**
 * Class Router
 */
class Router
{
    private static $routers = [];
    private $config;

    function __construct($config)
    {
        $this->config = $config;
    }

    private function getRequestURL()
    {
        $basePath = $this->config['basePath'];

        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $url = str_replace($basePath, '', $url);
        return $url;
    }

    private function getRequestMethod()
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        return $method;
    }

    private static function addRouter($method, $url, $action)
    {
        self::$routers[] = [$method, $url, $action];
    }

    public static function get($url, $action)
    {
        self::addRouter('GET', $url, $action);
    }

    public static function post($url, $action)
    {
        self::addRouter('POST', $url, $action);
    }

    public static function any($url, $action)
    {
        self::addRouter('GET|POST', $url, $action);
    }

    public function map()
    {
        $checkRoute = false;
        $params = [];
        $requestUrl = $this->getRequestURL();
        $requestMethod = $this->getRequestMethod();

        $routers = self::$routers;

        foreach ($routers as $router) {
            list($method, $url, $action) = $router;
            if (strpos($method, $requestMethod) === false) {
                continue;
            }

            if ($url === '*') {
                $checkRoute = true;
            } else if (strpos($url, '{') === false) {
                if (strcmp(strtolower($url), strtolower($requestUrl)) === 0) {
                    $checkRoute = true;
                } else {
                    continue;
                }
            } else if (strpos($url, '}') === false) {
                continue;
            } else {
                $routeParams = explode('/', $url);
                $requestParams = explode('/', $requestUrl);

                if (count($routeParams) !== count($requestParams)) {
                    continue;
                }

                foreach ($routeParams as $k => $rp) {
                    if (preg_match('/^{\w+}$/', $rp)) {
                        $params[] = $requestParams[$k];
                    }
                }
                $checkRoute = true;
            }

            if ($checkRoute === true) {
                if (is_callable($action)) {
                    call_user_func_array($action, $params);
                } else if (is_string($action)) {
                    $this->compileRoute($action, $params);
                }
                return;
            } else {
                continue;
            }
        }
        return;
    }

    private function compileRoute($action, $params)
    {
        if (count(explode('@', $action)) != 2) {
            die('Router error !!');
        } else {
            $className = explode('@', $action)[0];
            $methodName = explode('@', $action)[1];

            $classNamespace = 'app\controllers\\'.$className;

            if (class_exists($classNamespace)) {
                $object = new $classNamespace;
                Registry::getInstance()->controller = $className;
                if (method_exists($classNamespace, $methodName)) {
                    Registry::getInstance()->action = $methodName;
                    call_user_func_array([$object, $methodName], $params);
                } else {
                    throw new AppException('Method' . $methodName . ' do not exists');
                }
            } else {
                throw new AppException('Class' . $classNamespace . 'not found');
            }
        }
    }

    public function run()
    {
        $this->map();
    }
}