<?php

spl_autoload_register(function ($className) {
    $srcDir = 'src';
    $fileName  = __DIR__ . DIRECTORY_SEPARATOR . $srcDir . DIRECTORY_SEPARATOR;
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= $className . '.php';

    require $fileName;
});
