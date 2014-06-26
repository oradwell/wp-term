<?php

use Ockcyp\WpJsCli\Entity\Post;

class PostTest extends PHPUnit_Framework_TestCase
{
    public function testSetsHostname()
    {
        $hostname = 'http://www.google.com';

        $post = new Post;
        $post->type = 'page';
        $post->postname = 'me-and-my-dog';
        $post->setHostName($hostname);

        $this->assertEquals(
            $hostname . '/' . $post->postname,
            $post->getPostUrl()
        );
    }

    /**
     * @dataProvider postObjectUrlStructureProvider
     */
    public function testPostUrlStructure(Post $post, $structure, $expected)
    {
        $post->setPermalinkStructure($structure);

        $this->assertEquals($expected, $post->getPostUrl());
    }

    public function postObjectUrlStructureProvider()
    {
        $post = new Post;

        $post->post_id = '25';
        $post->year = '2014';
        $post->monthnum = '01';
        $post->day = '02';
        $post->postname = 'me-and-my-dog';
        $post->type = 'post';
        $post->setHostName('');

        return array(
            array(
                $post,
                '/%year%/%monthnum%/%day%/%postname%/',
                '/2014/01/02/me-and-my-dog/'
            ),
            array(
                $post,
                '/%year%/%monthnum%/%postname%/',
                '/2014/01/me-and-my-dog/'
            ),
            array(
                $post,
                '/%year%/%postname%/',
                '/2014/me-and-my-dog/'
            ),
            array(
                $post,
                '/archives/%post_id%/',
                '/archives/25/'
            ),
            array(
                $post,
                '/%postname%/',
                '/me-and-my-dog/'
            ),
        );
    }
}
