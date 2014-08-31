<?php

namespace Ockcyp\WpTerm\PostProvider;

class File extends PostProviderAbstract
{
    /**
     * File handle
     *
     * @var resource
     */
    protected $fh;

    /**
     * Current row
     *
     * @var array
     */
    protected $current;

    /**
     * Row ID
     *
     * @var integer
     */
    protected $key;

    /**
     * Initialise
     *
     * @param $fh File handle
     */
    public function __construct($fh)
    {
        $this->fh = $fh;
    }

    /**
     * Get post ID
     *
     * @return integer Post ID
     */
    public function getId()
    {
        return (int) $this->current[0];
    }

    /**
     * Get post year
     *
     * @return integer Year
     */
    public function getYear()
    {
        return (int) $this->current[1];
    }

    /**
     * Get post month number
     *
     * @return integer Month
     */
    public function getMonthNum()
    {
        return (int) $this->current[2];
    }

    /**
     * Get day
     *
     * @return integer Day
     */
    public function getDay()
    {
        return (int) $this->current[3];
    }

    /**
     * Get post name
     *
     * @return string Post name
     */
    public function getPostName()
    {
        return $this->current[4];
    }

    /**
     * Get post type post|page
     *
     * @return string Post type
     */
    public function getType()
    {
        return $this->current[5];
    }

    /**
     * Get current row as Post object while iterating
     *
     * @return Post
     */
    public function current()
    {
        return $this->getPostInstance();
    }

    /**
     * Iterate to next post
     */
    public function next()
    {
        $this->key++;
        $this->current = fgetcsv($this->fh);
    }

    /**
     * Get iteration key
     *
     * @return integer Key
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Move to beginning of the iteration
     */
    public function rewind()
    {
        if (!$this->fh) {
            return;
        }

        rewind($this->fh);
        $this->key = 0;
        $this->current = fgetcsv($this->fh);
    }

    /**
     * Check if current iteration is valid
     *
     * @return boolean True if iteration is valid
     */
    public function valid()
    {
        return (bool) $this->current;
    }
}
