<?php

namespace OckCyp\WpTerm\Config;

class Config
{
    protected static $config;
    protected static $env = null;

    public static function get($env = 'prod')
    {
        if (static::$env === $env) {
            return static::$config;
        }

        $fileName = 'app.php';
        if ($env && $env != 'prod') {
            $fileName = "app_$env.php";
        }

        static::$env = $env;

        return static::$config = require APP_PATH . '/config/' . $fileName;
    }
}
