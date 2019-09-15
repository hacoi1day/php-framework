<?php

// singleton
// design pattern

class A
{
    private static $instance;
    private $storage;

    private function __construct()
    {

    }
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function __set($name, $value)
    {
        if (!isset($this->storage[$name])) {
            $this->storage[$name] = $value;
        }
    }
    public function __get($name)
    {
        if (isset($this->storage[$name])) {
            return $this->storage[$name];
        } else {
            return null;
        }
    }
}

////$a = new A();
//$a = A::getInstance();
//var_dump($a);
//echo '<br>';
//
////$b = new A();
//$b = A::getInstance();
//var_dump($b);
//echo '<br>';
//
////$c = new A();
//$c = A::getInstance();
//var_dump($c);
//echo '<br>';

$a = A::getInstance();

$a->name = 'havt';

echo $a->name;