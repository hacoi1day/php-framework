<?php

namespace app\core;
use Exception;
use Throwable;

class AppException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        set_exception_handler([$this, 'error_handle']);
        parent::__construct($message, $code, $previous);
    }

    public function error_handle($exception)
    {
        echo '<h1 style="color: red;">'.$exception->getCode().' => '.$exception->getMessage().'</h1>';
        echo "<h2>{$exception->getFile()} => {$exception->getLine()}</h2>";
        echo "<p>{$exception->getTraceAsString()}</p>";
        echo "<hr>";
        foreach ($exception->getTrace() as $trace) {
            $file = isset($trace['file']) ? $trace['file'] : '';
            $line = isset($trace['line']) ? $trace['line'] : '';
            $class = isset($trace['class']) ? $trace['class'] : '';
            $function = isset($trace['function']) ? $trace['function'] : '';

            echo "<h4>File: {$file}</h4>";
            echo "<h4>Line: {$line}</h4>";
            echo "<h4>Class: {$class}</h4>";
            echo "<h4>Function: {$function}</h4>";
            echo "<hr>";
        }
    }
}