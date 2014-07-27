<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\Command\CommandFactory;
use Ockcyp\WpTerm\Exception\InvalidCommandException;

class HelpCommand extends CommandAbstract
{
    public static $usage = '[<command name>]';

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
        foreach (CommandFactory::$commandList as $command) {
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
