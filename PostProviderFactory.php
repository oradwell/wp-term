<?php

class PostProviderFactory
{
    protected static $init = false;
    protected static $config = null;

    public static function make()
    {
        static::init();

        return static::getCurrentProvider();
    }

    protected static function getCurrentProvider()
    {
        $postSrc = $this->config['post_src'];
        switch ($this->config[$postSrc]['type']) {
            case 'file':
                $fh = fopen($this->config[$postSrc]['path'], 'r');
                return new FilePostProvider($fh);
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

        $this->config = require __DIR__ . '/config/app.php';
        $this->init = true;
    }
}
