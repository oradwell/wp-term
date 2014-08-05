<?php

namespace Ockcyp\WpTerm\PostProvider;

use PDO;

class Database extends PostProviderAbstract
{
    /**
     * PDO connection
     *
     * @var PDO
     */
    protected $dbh;

    /**
     * PDO statement
     *
     * @var PDOStatement
     */
    protected $stmt;

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
     * @param PDO $dbh PDO connection
     */
    public function __construct($dbh)
    {
        $this->dbh = $dbh;
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
        $this->current = $this->stmt->fetch(PDO::FETCH_NUM);
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
        if (!$this->dbh) {
            return;
        }

        $sql  = "SELECT `ID`, YEAR(`post_date`), MONTH(`post_date`),";
        $sql .= " DAY(`post_date`), `post_name`, `post_type`";
        $sql .= " FROM `wp_posts`";
        $sql .= " WHERE post_type IN ('post', 'page') AND post_name != ''";
        $this->stmt = $this->dbh->query($sql);

        $this->key = 0;
        $this->current = $this->stmt->fetch(PDO::FETCH_NUM);
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
