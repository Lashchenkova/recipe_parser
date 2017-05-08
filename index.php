<?php

function __autoload($class_name)
{
    $filename = "lib/{$class_name}.php";
    if(file_exists($filename)){
        require_once($filename);
    } else {
        throw new Exception('Failed to load' . $class_name);
    }
}

App::run();
