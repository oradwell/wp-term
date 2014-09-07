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

        $aliasData = static::$commandAliasMap[$executable];
        
        return static::makeCommandFromAliasData($aliasData);
    }

    /**
     * Makes a command from alias data
     *
     * @param  array $aliasData Alias data of the executable given
     *
     * @return CommandAbstract  Instance of a class
     *                          that extends CommandAbstract
     *
     * @throws \RuntimeException If command alias map definition is invalid
     */
    protected static function makeCommandFromAliasData($aliasData)
    {
        if (isset($aliasData['command'])) {
            return static::makeCommandFromClassName($aliasData['command']);
        }

        if (!isset($aliasData['aliasOf'])) {
            // This should never be reached
            throw new \RuntimeException('Invalid command alias map definition');
        }

        $command = static::make($aliasData['aliasOf']);

        return static::prepareCommandObject($command, $aliasData);
    }

    /**
     * Make command from class name
     *
     * @param  string $commandClass Command class without namespace
     *
     * @return CommandAbstract      Instance of the command
     */
    protected static function makeCommandFromClassName($commandClass)
    {
        $fullCmdClass = __NAMESPACE__ . '\\' . $commandClass;

        return new $fullCmdClass;
    }

    /**
     * Prepare command by adding argument and changing its name 
     *
     * @param  CommandAbstract $command Command to be prepared
     * @param  array  $aliasData        Alias data of the executable
     *
     * @return CommandAbstract          Prepared command
     */
    protected static function prepareCommandObject($command, $aliasData)
    {
        if (isset($aliasData['arg'])) {
            $command->addArgument($aliasData['arg']);
        }

        if (isset($aliasData['name'])) {
            $command->setName($aliasData['name']);
        }

        return $command;
    }
}
