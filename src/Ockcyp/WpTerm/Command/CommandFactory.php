<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\Exception\InvalidCommandException;

class CommandFactory
{
    public static $commandList = array(
        'clear',
        'exit',
        'goto',
        'help',
        'history',
        'list',
    );

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
                    ->addArgument('--pages');
            case 'list-posts':
                return static::make('list')
                    ->addArgument('--posts');
            case 'goto':
                return new GotoCommand;
            case 'help':
                return new HelpCommand;
            case 'complete':
                return new CompleteCommand;
            default:
                // If a valid command but no class mapping defined
                // instantiate a JsCommand and set name to executable
                if (in_array($executable, static::$commandList)) {
                    return new JsCommand($executable);
                }
                throw new InvalidCommandException(
                    'Command not found: ' . $executable
                );
        }
    }
}
