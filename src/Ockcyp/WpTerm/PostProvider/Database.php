<?php

namespace Ockcyp\WpTerm\PostProvider;

use PDO;

class Database extends PostProviderAbstract
{
    protected $dbh;
    protected $stmt;
    protected $current;
    protected $key;

    public function __construct($dbh)
    {
        $this->dbh = $dbh;
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
        $this->current = $this->stmt->fetch(PDO::FETCH_NUM);
    }

    public function key()
    {
        return $this->key;
    }

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

    public function valid()
    {
        return (bool) $this->current;
    }
}
