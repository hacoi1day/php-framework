<?php

class Person {
    public $face;

    public function walk()
    {
        echo "walk";
    }
}

class Student extends Person
{
    public $name;
    public $age;
    public $gender;

    function __construct($name, $face)
    {
        $this->name = $name;
        $this->face = $face;
    }

    public function listen()
    {

    }

    public function read()
    {
        echo "Student reading book";
    }

    public function say()
    {
        echo 'Hello my name is ' . $this->name . '<br>';
        echo 'My face is ' . $this->face;
    }

//    public function walk()
//    {
//        echo "Chạy";
//    }

    public function __destruct()
    {
        echo "Student is die";
    }

}

$student = new Student("Vũ Thanh Hà", "Mặt trái xoan");
$student->read();
echo '<br>';
$student->say();
echo '<br>';
$student->walk();
echo '<br>';
unset($student);