<?php

class Post
{
    public $post_id;
    public $year;
    public $monthnum;
    public $day;
    public $postname;
    public $type;

    protected static $permalinkVariables = array(
        'post_id',
        'year',
        'monthnum',
        'day',
        'postname'
    );

    protected $hostname = 'http://www.ockwebs.com';
    protected $permalinkStructure = '/%year%/%monthnum%/%postname%/';

    public function setHostName($hostname)
    {
        $this->hostname = $hostname;
    }

    public function setPermalinkStructure($structure)
    {
        $this->permalinkStructure = $structure;
    }

    public function getPostUrl()
    {
        return $this->hostname . $this->getUrlPath();
    }

    protected function getUrlPath()
    {
        if ($this->type === 'PAGE') {
            return '/' . $this->postname;
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
