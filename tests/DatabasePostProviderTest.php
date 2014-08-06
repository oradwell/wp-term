<?php

use Ockcyp\WpTerm\Config\Config;
use Ockcyp\WpTerm\PostProvider\Database as DatabasePostProvider;

class DatabasePostProviderTest extends PHPUnit_Framework_TestCase
{
    protected $dbh;
    protected $posts;

    public function __construct($name = null, $data = array(), $dataName = '')
    {
        $config = Config::get('test');

        $dbConfig = $config['post_src_db'];
        $conStr  = $dbConfig['driver'];
        $conStr .= ':host=' . $dbConfig['host'] . ';';
        $conStr .= 'dbname=' . $dbConfig['dbname'];
        $this->dbh = new PDO(
            $conStr,
            $dbConfig['username'],
            $dbConfig['password']
        );

        $this->posts = new DatabasePostProvider($this->dbh);

        parent::__construct($name, $data, $dataName);
    }

    public function testNoDatabaseHandle()
    {
        $postList = new DatabasePostProvider(null);

        $flag = false;
        foreach ($postList as $post) {
            $flag = true;
        }

        $this->assertEmpty($flag);
    }

    public function testIsIterator()
    {
        $this->assertInstanceOf('Iterator', $this->posts);
    }

    public function testIterates()
    {
        foreach ($this->posts as $key => $post) {
            if (!isset($firstPost)) {
                $firstKey = $key;
                $firstPost = $post;
                continue;
            }

            $secondKey = $key;
            $secondPost = $post;
            break;
        }

        if (!isset($firstPost) || !isset($secondPost)) {
            $this->markTestSkipped('Not enough posts to test.');
        }

        $this->assertGreaterThan($firstKey, $secondKey);
        $this->assertNotEquals($firstPost, $secondPost);

        return $firstPost;
    }

    /**
     * @depends testIterates
     */
    public function testReturnsValidPostObject($post)
    {
        $this->assertInstanceOf('Ockcyp\WpTerm\Entity\Post', $post);

        $this->assertNotEmpty($post->post_id);
        $this->assertNotEmpty($post->year);
        $this->assertNotEmpty($post->monthnum);
        $this->assertNotEmpty($post->day);
        $this->assertNotEmpty($post->postname);
        $this->assertNotEmpty($post->type);

        $this->assertNotEmpty($post->getPostUrl());
    }
}
