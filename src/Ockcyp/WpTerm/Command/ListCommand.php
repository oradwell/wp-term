<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\PostProvider\PostProviderFactory;

class ListCommand extends CommandAbstract
{
    /**
     * Usage details of the command
     *
     * @var string
     */
    public static $usage = '[--pages|--posts]';

    /**
     * Accepted arguments
     *
     * @var array
     */
    protected static $validArguments = array(
        '--posts',
        '--pages',
        '--help',
    );

    /**
     * Name of the command used when printing usage
     *
     * @var string
     */
    protected $name = 'list';

    /**
     * Execute list command and return the response
     *
     * @return array Response
     */
    public function executeCommand()
    {
        return array(
            'list' => $this->getPostList(),
        );
    }

    /**
     * Gets list of posts using the post provider
     *
     * @return array List of posts
     */
    protected function getPostList()
    {
        $posts = PostProviderFactory::make();

        $postList = array();
        foreach ($posts as $post) {
            if ($this->isPostFiltered($post)) {
                continue;
            }
            $postList[] = $post->postname;
        }

        return $postList;
    }

    /**
     * Check whether the post is filtered out by arguments
     *
     * @param  string  $post Post name
     *
     * @return boolean       True if post is filtered out
     */
    protected function isPostFiltered($post)
    {
        if ($this->hasArgument('--posts')
            && !$this->hasArgument('--pages')
            && $post->type === 'page'
        ) {
            return true;
        }

        if ($this->hasArgument('--pages')
            && !$this->hasArgument('--posts')
            && $post->type === 'post'
        ) {
            return true;
        }

        return false;
    }
}
