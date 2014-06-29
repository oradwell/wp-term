<?php

namespace Ockcyp\WpPostsCli\PostProvider;

class File extends PostProviderAbstract
{
    protected $fh;
    protected $current;
    protected $key;

    public function __construct($fh)
    {
        $this->fh = $fh;
    }

    public function getId()
    {
        return $this->current[0];
    }

    public function getYear()
    {
        return $this->current[1];
    }

    public function getMonthNum()
    {
        return $this->current[2];
    }

    public function getDay()
    {
        return $this->current[3];
    }

    public function getPostName()
    {
        return $this->current[4];
    }

    public function getType()
    {
        return $this->current[5];
    }

    public function current()
    {
        return $this->getPostInstance();
    }

    public function next()
    {
        $this->key++;
        $this->current = fgetcsv($this->fh);
    }

    public function key()
    {
        return $this->key;
    }

    public function rewind()
    {
        if (!$this->fh) {
            return;
        }

        rewind($this->fh);
        $this->key = 0;
        $this->current = fgetcsv($this->fh);
    }

    public function valid()
    {
        return (bool) $this->current;
    }
}
