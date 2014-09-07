<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\Exception\InvalidCommandException;

class CommandFactory
{
    /**
     * List of available commands
     *
     * @var array
     */
    public static $commandList = array(
        'clear',
        'exit',
        'goto',
        'help',
        'history',
        'list',
    );

    /**
     * Map of command aliases
     *
     * @var array
     */
    public static $commandAliasMap = array(
        'ls' => array('aliasOf' => 'list', 'name' => 'ls'),
        'list' => array('command' => 'ListCommand'),
        'list-pages' => array('aliasOf' => 'list', 'arg' => '--pages'),
        'list-posts' => array('aliasOf' => 'list', 'arg' => '--posts'),
        'goto' => array('command' => 'GotoCommand'),
        'help' => array('command' => 'HelpCommand'),
        'complete' => array('command' => 'CompleteCommand'),
    );

    /**
     * Get instance of a Command class
     *
     * @param  string $executable Name of the executable
     *
     * @return CommandAbstract    Instance of a class
     *                            that extends CommandAbstract
     *
     * @throws Ockcyp\WpTerm\Exception\InvalidCommandException If command is not a valid command
     * @throws \RuntimeException If command alias map definition is invalid
     */
    public static function make($executable)
    {
        if (!isset(static::$commandAliasMap[$executable])) {
            // If a valid command but no class mapping defined
            // instantiate a JsCommand and set name to executable
            if (in_array($executable, static::$commandList)) {
                return new JsCommand($executable);
            }
            throw new InvalidCommandException(
                'Command not found: ' . $executable
            );
        }

        $aliasMap = static::$commandAliasMap[$executable];

        if (isset($aliasMap['command'])) {
            $cmdClass = __NAMESPACE__ . '\\' . $aliasMap['command'];
            return new $cmdClass;
        }

        if (!isset($aliasMap['aliasOf'])) {
            // This should never be reached
            throw new \RuntimeException('Invalid command alias map definition');
        }

        $command = static::make($aliasMap['aliasOf']);

        if (isset($aliasMap['arg'])) {
            $command->addArgument($aliasMap['arg']);
        }

        if (isset($aliasMap['name'])) {
            $command->setName($aliasMap['name']);
        }
        
        return $command;
    }
}
