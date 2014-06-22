<?php

require __DIR__ . '/ListCommand.php';
require __DIR__ . '/InvalidCommandException.php';

class CommandFactory
{
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
