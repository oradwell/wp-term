<?php

namespace Ockcyp\WpPostsCli\PostProvider;

use Ockcyp\WpPostsCli\PostProvider\File as FilePostProvider;

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
                // not implemented yet
                return null;
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
