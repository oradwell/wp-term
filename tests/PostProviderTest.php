<?php

use Ockcyp\WpTerm\PostProvider\File as FilePostProvider;

class PostProviderTest extends PHPUnit_Framework_TestCase
{
    protected $fh;
    protected $posts;

    public function __construct($name = null, $data = array(), $dataName = '')
    {
        $this->fh = fopen(APP_PATH . '/posts.csv', 'r');
        $this->posts = new FilePostProvider($this->fh);

        parent::__construct($name, $data, $dataName);
    }

    public function __destruct()
    {
        fclose($this->fh);
    }

    public function testNoFileHandle()
    {
        $postList = new FilePostProvider(null);

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
