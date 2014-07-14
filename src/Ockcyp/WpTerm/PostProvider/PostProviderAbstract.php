<?php

namespace Ockcyp\WpTerm\PostProvider;

use Ockcyp\WpTerm\Entity\Post;

abstract class PostProviderAbstract implements \Iterator
{
    protected function getPostInstance()
    {
        $post = new Post;

        $post->post_id = $this->getId();
        $post->year = $this->getYear();
        $post->monthnum = $this->getMonthNum();
        $post->day = $this->getDay();
        $post->postname = $this->getPostName();
        $post->type = $this->getType();

        return $post;
    }

    abstract public function getId();
    abstract public function getYear();
    abstract public function getMonthNum();
    abstract public function getDay();
    abstract public function getPostName();
    abstract public function getType();
}