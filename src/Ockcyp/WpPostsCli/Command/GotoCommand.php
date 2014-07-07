<?php

namespace Ockcyp\WpPostsCli\Command;

use Ockcyp\WpPostsCli\PostProvider\PostProviderFactory;
use Ockcyp\WpPostsCli\Exception\MissingCommandArgumentException;
use Ockcyp\WpPostsCli\Exception\PostNotFoundException;

class GotoCommand extends CommandAbstract
{
    public static $usage = '<postname>';
    protected $name = 'goto';

    public function executeCommand()
    {
        $post = $this->findPost($this->arguments[0]);

        return array(
            'url' => $post->getPostUrl(),
        );
    }

    protected function findPost($postname)
    {
        $posts = PostProviderFactory::make();

        foreach ($posts as $post) {
            if ($postname === $post->postname) {
                return $post;
            }
        }

        throw new PostNotFoundException('Post not found: ' . $postname);
    }

    protected function checkArgumentsValid()
    {
        if (!$this->arguments) {
            throw new MissingCommandArgumentException('Missing argument: postname');
        }
    }
}
