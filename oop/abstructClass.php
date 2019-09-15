<?php

class Person
{
    public $face;

    public function walk()
    {
        echo "walk";
    }
}

abstract class Student extends Person
{
    public $name = 'Hà';
    protected $age = 21;
//    private $gender = 'male';
    abstract public function say();
}

class StudentA extends Student
{

    public function __construct()
    {
        $this->face = 'Mặt trái xoan';
    }

    public function say()
    {
        echo "Hello" . '<br>';
        echo $this->age;
    }
}

$studentA = new StudentA();
echo $studentA->name . '<br>';
echo $studentA->face . '<br>';
$studentA->say();