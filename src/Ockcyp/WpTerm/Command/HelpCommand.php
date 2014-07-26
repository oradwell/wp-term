<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\Command\CommandFactory;
use Ockcyp\WpTerm\Exception\InvalidCommandException;

class HelpCommand extends CommandAbstract
{
    public static $usage = '[<command name>]';

    protected static $commands = array(
        'history',
        'clear',
        'exit',
        'list',
        'goto',
        'help',
    );

    protected $name = 'help';

    /**
     * Execute help command and return the response
     *
     * @return array Response
     */
    public function executeCommand()
    {
        if (isset($this->arguments[0])) {
            return CommandFactory::make($this->arguments[0])
                ->usage();
        }

        return array(
            'list' => $this->getCommandUsages(),
        );
    }

    protected function getCommandUsages()
    {
        $usageList = array();
        foreach (static::$commands as $command) {
            try {
                $cmdInstance = CommandFactory::make($command);
                $cmdClass = get_class($cmdInstance);
                $usageList[] = htmlentities($command . ' ' . $cmdClass::$usage);
            } catch (InvalidCommandException $e) {
                $usageList[] = $command;
            }
        }

        return $usageList;
    }

    protected function checkArgumentsValid()
    {
        return;
    }
}
