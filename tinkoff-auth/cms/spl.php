<?php

function tinkoffAuthAutoLoader($class_name)
{
    // Формируем корректное имя класса
    $class_name = str_replace('TinkoffAuth\\', '', $class_name);
    $class_name = str_replace('\\', '/', $class_name) . '.php';


    // Если это служебные классы для CMS, то подключаем их из текущей директории
    if (strpos($class_name, 'CMS') === 0) {
        $class_name = str_replace('CMS', '', $class_name);
        $class_name = lcfirst(ltrim($class_name, '/'));
        $file_path  = __DIR__ . '/' . $class_name;
    } else {
        // Иначе обращаемся к src директории
        $file_path = __DIR__ . '/../src/' . $class_name;
    }


    $file_path = str_replace('//', '/', $file_path);
    if (file_exists($file_path)) {
        require_once $file_path;
    }
}

spl_autoload_register('tinkoffAuthAutoLoader');