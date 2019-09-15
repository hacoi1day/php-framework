<?php

interface Person
{
    public function say();
    public function walk();
}
interface Human
{
    public function run();
}

class Student implements Person, Human
{
    protected $name = 'havt';
    private $age = 21;
    public function say()
    {
        echo "Student say" . '<br>';
        echo $this->name;
    }

    public function walk()
    {
        echo "Student walk";
    }

    public function run()
    {
        echo "Student run";
    }

    public function getName()
    {
        return $this->name;
    }
}

$student = new Student();
$student->say();
echo $student->getName();