<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\Exception\CommandNotExecutableException;

class JsCommand extends CommandAbstract
{
    /**
     * Command name
     *
     * @var string
     */
    protected $name;

    /**
     * Set name of the command
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * This should not be reached so throw exception
     *
     * @throws CommandNotExecutableException If command is executed
     */
    public function executeCommand()
    {
        throw new CommandNotExecutableException($this->name . ' is not executable.');
    }
}
