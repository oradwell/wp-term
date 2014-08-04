<?php

namespace Ockcyp\WpTerm\PostProvider;

use Ockcyp\WpTerm\PostProvider\File as FilePostProvider;
use Ockcyp\WpTerm\PostProvider\Database as DatabasePostProvider;
use Ockcyp\WpTerm\Config\Config;
use Ockcyp\WpTerm\Exception\UnsupportedPostSourceTypeException;
use PDO;

class PostProviderFactory
{
    /**
     * Initialised flag
     *
     * @var boolean
     */
    protected static $init = false;

    /**
     * Config parameters
     *
     * @var array
     */
    protected static $config = null;

    /**
     * Post provider
     *
     * @var PostProviderAbstract
     */
    protected static $provider = null;

    /**
     * Makes a post provider that is defined in the config
     *
     * @return PostProviderAbstract
     */
    public static function make()
    {
        static::init();

        return static::getCurrentProvider();
    }

    /**
     * Sets the config used in the class
     *
     * @param array $config Config parameters
     */
    public static function setConfig($config)
    {
        static::$config = $config;
        static::$init = true;
        static::$provider = null;
    }

    /**
     * Returns the post provider set in the config
     *
     * @return PostProviderAbstract
     */
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

        throw new UnsupportedPostSourceTypeException();
    }

    /**
     * Initialises the class by getting the config
     */
    protected static function init()
    {
        if (static::$init) {
            return;
        }

        static::$config = Config::get();
        static::$init = true;
    }
}
