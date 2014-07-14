<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\PostProvider\PostProviderFactory;

class ListCommand extends CommandAbstract
{
    public static $usage = '[--pages|--posts]';

    protected static $validArguments = array(
        '--posts',
        '--pages',
        '--help',
    );

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
