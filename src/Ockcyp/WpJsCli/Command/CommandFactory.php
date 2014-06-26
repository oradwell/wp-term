<?php

namespace Ockcyp\WpJsCli\Command;

use Ockcyp\WpJsCli\Command\GotoCommand;
use Ockcyp\WpJsCli\Command\ListCommand;
use Ockcyp\WpJsCli\Exception\InvalidCommandException;

class CommandFactory
{
    /**
     * Get instance of a Command class
     *
     * @param  string $executable Name of the executable
     *
     * @return CommandAbstract    Instance of a class
     *                            that extends CommandAbstract
     */
    public static function make($executable)
    {
        switch ($executable) {
            case 'ls':
            case 'list':
                return new ListCommand;
            case 'list-pages':
                return static::make('list')
                    ->addArguments('--pages');
            case 'list-posts':
                return static::make('list')
                    ->addArguments('--posts');
            case 'goto':
                return new GotoCommand;
            default:
                throw new InvalidCommandException(
                    'Command not found: ' . $executable
                );
        }
    }
}
