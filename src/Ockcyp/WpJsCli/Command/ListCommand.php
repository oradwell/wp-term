<?php

namespace Ockcyp\WpJsCli\Command;

use Ockcyp\WpJsCli\PostProvider\PostProviderFactory;

class ListCommand extends CommandAbstract
{
    protected static $validArguments = array(
        '--posts',
        '--pages',
    );

    /**
     * Execute list command and return the response
     *
     * @return array Response
     * @throws InvalidCommandArgumentException If has any invalid arguments
     */
    public function execute()
    {
        $this->checkArgumentsValid();

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
