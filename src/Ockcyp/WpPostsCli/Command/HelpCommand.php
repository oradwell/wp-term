<?php

namespace Ockcyp\WpPostsCli\Command;

use Ockcyp\WpPostsCli\Command\CommandFactory;

class HelpCommand extends CommandAbstract
{
    public static $usage = '[<command name>]';

    protected static $commands = array(
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
            $cmdClass = get_class(CommandFactory::make($command));
            $usageList[] = htmlentities($command . ' ' . $cmdClass::$usage);
        }

        return $usageList;
    }

    protected function checkArgumentsValid()
    {
        return;
    }
}
