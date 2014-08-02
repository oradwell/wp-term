<?php

namespace Ockcyp\WpTerm\Entity;

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
     * Hostname of the website to be used in generated urls
     *
     * @var string
     */
    protected $hostname = 'http://www.ockwebs.com';

    /**
     * URL structure of permalink as seen in WordPress Permalink Settings
     *
     * @var string
     */
    protected $permalinkStructure = '/%year%/%monthnum%/%postname%/';

    /**
     * Sets hostname
     *
     * @param string $hostname Hostname
     */
    public function setHostName($hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * Sets permalink structure
     *
     * @param string $structure Permalink structure
     */
    public function setPermalinkStructure($structure)
    {
        $this->permalinkStructure = $structure;
    }

    /**
     * Generates post url
     *
     * @return string Post url
     */
    public function getPostUrl()
    {
        return $this->hostname . $this->getUrlPath();
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
            $this->permalinkStructure
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
