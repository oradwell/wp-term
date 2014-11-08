<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\Command\CommandFactory;

class HelpCommand extends CommandAbstract
{
    /**
     * Usage details of the command
     *
     * @var string
     */
    public static $usage = '[<command name>]';

    /**
     * Name of the command used when printing usage
     *
     * @var string
     */
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

    /**
     * Get usage information of all the commands defined in CommandFactory
     *
     * @return array List of usages
     */
    protected function getCommandUsages()
    {
        $usageList = array();
        foreach (CommandFactory::$commandList as $command) {
            $cmdClass = get_class(CommandFactory::make($command));
            $usageList[] = htmlentities($command . ' ' . $cmdClass::$usage);
        }

        return $usageList;
    }

    /**
     * Always valid
     */
    protected function checkArgumentsValid()
    {
        return;
    }
}
