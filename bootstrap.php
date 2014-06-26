<?php

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/src');

spl_autoload_register(function ($className) {
    if (strpos($className, 'Ockcyp') !== 0) {
        return;
    }

    $fileName  = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    include $fileName;
});
