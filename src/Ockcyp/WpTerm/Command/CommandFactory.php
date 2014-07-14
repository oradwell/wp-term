<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\Command\GotoCommand;
use Ockcyp\WpTerm\Command\ListCommand;
use Ockcyp\WpTerm\Exception\InvalidCommandException;

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
                return static::make('list')
                    ->setName('ls');
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
            case 'help':
                return new HelpCommand;
            default:
                throw new InvalidCommandException(
                    'Command not found: ' . $executable
                );
        }
    }
}
