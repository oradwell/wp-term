<?php

namespace Ockcyp\WpPostsCli\Command;

use Ockcyp\WpPostsCli\PostProvider\PostProviderFactory;
use Ockcyp\WpPostsCli\Exception\MissingCommandArgumentException;
use Ockcyp\WpPostsCli\Exception\PostNotFoundException;

class GotoCommand extends CommandAbstract
{
    /**
     * Usage of the command excluding the executable name
     *
     * @var string
     */
    public static $usage = '<postname>';

    /**
     * Name of the command
     *
     * @var string
     */
    protected $name = 'goto';

    /**
     * Executes Goto command
     *
     * @return array Response
     */
    public function executeCommand()
    {
        $post = $this->findPost($this->arguments[0]);

        return array(
            'url' => $post->getPostUrl(),
        );
    }

    /**
     * Finds the post using the PostProvider
     *
     * @param  string $postname Name of the post
     *
     * @return Post
     * @throws PostNotFoundException If post cannot be found
     */
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

    /**
     * Check command has required postname argument
     */
    protected function checkArgumentsValid()
    {
        if (!$this->arguments) {
            throw new MissingCommandArgumentException('Missing argument: postname');
        }
    }
}
