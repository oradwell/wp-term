<?php

namespace Ockcyp\WpTerm\Entity;

use Ockcyp\WpTerm\Config\Config;

class Post
{
    /**
     * Post ID
     *
     * @var integer
     */
    public $post_id;

    /**
     * Year
     *
     * @var integer
     */
    public $year;

    /**
     * Month number
     *
     * @var integer
     */
    public $monthnum;

    /**
     * Day number
     *
     * @var integer
     */
    public $day;

    /**
     * Post name
     *
     * @var string
     */
    public $postname;

    /**
     * Post type page or post
     *
     * @var string
     */
    public $type;

    /**
     * List of variables that can be used as tokens in url
     *
     * @var array
     */
    protected static $permalinkVariables = array(
        'post_id',
        'year',
        'monthnum',
        'day',
        'postname'
    );

    /**
     * Config
     *
     * @var array
     */
    protected $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        $config = Config::get();

        $this->setConfig($config);
    }

    /**
     * Sets config
     *
     * @param array $config Config
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Generates post url
     *
     * @return string Post url
     */
    public function getPostUrl()
    {
        return $this->config['hostname'] . $this->getUrlPath();
    }

    protected function getUrlPath()
    {
        if ($this->type === 'page') {
            return '/' . $this->postname . '/';
        }

        return $this->getPostPermalinkFromStructure();
    }

    protected function getPostPermalinkFromStructure()
    {
        $urlPath = str_replace(
            static::getPermalinkTokens(),
            $this->getPermalinkTokenValues(),
            $this->config['permalink_structure']
        );

        return $urlPath;
    }

    protected function getPermalinkTokens()
    {
        $tokens = array();
        foreach (static::$permalinkVariables as $variable) {
            $tokens[] = "%{$variable}%";
        }

        return $tokens;
    }

    protected function getPermalinkTokenValues()
    {
        $tokenValues = array();
        foreach (static::$permalinkVariables as $variable) {
            $tokenValues[] = $this->$variable;
        }

        return $tokenValues;
    }
}
