<?php

namespace app\core;
use App;
use app\core\Registry;

/**
 * Class Controller - Base controller
 */
class Controller
{
    private $layout = null;
    private $config;

    function __construct()
    {
        $this->config = Registry::getInstance()->config;
        $this->layout = $this->config['layout'];
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function redirect($url, $isEnd = true, $responseCode = 302)
    {
        header('Location:'.$url, true, $responseCode);
        if ($isEnd === true) {
            die();
        }
    }
    public function render($view, $data = null)
    {
        $rootDir = $this->config['rootDir'];

        $content = $this->getViewContent($view, $data);
        if ($this->layout !== null) {
            $layoutPath = $rootDir.'\app\views\\'.$this->layout.'.php';
            if (file_exists($layoutPath)) {
                require($layoutPath);
            }
        }
    }

    public function getViewContent($view, $data = null)
    {
        $controller = Registry::getInstance()->controller;
        $folderView = strtolower(str_replace('Controller', '', $controller));
        $rootDir = $this->config['rootDir'];

        if (is_array($data)) {
            extract($data, EXTR_PREFIX_SAME, "data");
        } else {
            $data = $data;
        }
        $viewPath = $rootDir.'\app\views\\'.$folderView.'\\'.$view.'.php';
        if (file_exists($viewPath)) {
            ob_start();
            require($viewPath);
            $content = ob_get_clean();
            ob_end_clean();
            return $content;
        }
    }

    public function renderPartial($view, $data = null)
    {
        $rootDir = $this->config['rootDir'];
        if (is_array($data)) {
            extract($data, EXTR_PREFIX_SAME, "data");
        } else {
            $data = $data;
        }
        $viewPath = $rootDir.'\app\views\\'.$view.'.php';
        if (file_exists($viewPath)) {
            require($viewPath);
        }
    }
}