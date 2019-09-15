<!--// các hàm tự động load các file trong controller, config-->

<?php

use app\core\AppException;

class Autoload
{
    private $rootDir;

    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
        spl_autoload_register([$this, 'autoload']);
        $this->autoLoadFile();
    }

    private function autoload($class)
    {
        $arrClass = explode('\\', $class);
        $className = end($arrClass);
        $pathName = str_replace($className, '', $class);

        $filePath = $this->rootDir . '\\' . $pathName . $className . '.php';

        if (file_exists($filePath)) {
            require_once($filePath);
        } else {
            throw new AppException($className . ' does not exists', 1);
            die();
        }
    }

    private function autoLoadFile()
    {
        foreach ($this->defaultFileLoad() as $file)
        {
            require_once($this->rootDir . '/' . $file);
        }
    }

    private function defaultFileLoad()
    {
        return [
            'app/core/Router.php',
            'app/routers.php'
        ];
    }
}