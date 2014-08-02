<?php

namespace OckCyp\WpTerm\Config;

class Config
{
    /**
     * Config variables
     *
     * @var array
     */
    protected static $config;

    /**
     * Environment prod or test
     *
     * @var string
     */
    protected static $env = null;

    /**
     * Gets the config array for the given environment
     *
     * @param  string $env Environment
     *
     * @return array       Config array
     */
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
