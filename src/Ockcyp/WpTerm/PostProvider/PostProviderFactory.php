<?php

namespace Ockcyp\WpTerm\PostProvider;

use Ockcyp\WpTerm\PostProvider\File as FilePostProvider;
use Ockcyp\WpTerm\PostProvider\Database as DatabasePostProvider;
use PDO;

class PostProviderFactory
{
    protected static $init = false;
    protected static $config = null;
    protected static $provider = null;

    public static function make()
    {
        static::init();

        return static::getCurrentProvider();
    }

    protected static function getCurrentProvider()
    {
        if (static::$provider) {
            return static::$provider;
        }

        $postSrc = static::$config['post_src'];
        switch (static::$config[$postSrc]['type']) {
            case 'file':
                $fh = fopen(
                    APP_PATH . '/' . static::$config[$postSrc]['path'],
                    'r'
                );

                return static::$provider = new FilePostProvider($fh);
            case 'db':
                $dbConfig = static::$config[$postSrc];
                $conStr  = $dbConfig['driver'];
                $conStr .= ':host=' . $dbConfig['host'] . ';';
                $conStr .= 'dbname=' . $dbConfig['dbname'];
                $dbh = new PDO(
                    $conStr,
                    $dbConfig['username'],
                    $dbConfig['password']
                );

                return static::$provider = new DatabasePostProvider($dbh);
        }
    }

    protected static function init()
    {
        if (static::$init) {
            return;
        }

        static::$config = require APP_PATH . '/config/app.php';
        static::$init = true;
    }
}
