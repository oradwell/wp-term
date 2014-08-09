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
    public static function get($env = null)
    {
        // If no environment specified
        // use previously set environment or prod
        if (!$env) {
            $env = static::$env ? static::$env : 'prod';
        }

        if (static::$env && static::$env === $env) {
            return static::$config;
        }

        $fileName = 'app.php';
        if ($env != 'prod') {
            $fileName = "app_$env.php";
        }

        static::$env = $env;

        return static::$config = require APP_PATH . '/config/' . $fileName;
    }

    /**
     * Get current environment
     *
     * @return string Environment
     */
    public static function getEnv()
    {
        return static::$env;
    }

    /**
     * Clear environment for testing
     */
    public static function clear()
    {
        static::$env = null;
        static::$config = null;
    }
}
