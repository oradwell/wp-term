<?php

namespace Ockcyp\WpPostsCli\Command;

use Ockcyp\WpPostsCli\Exception\InvalidCommandArgumentException;

abstract class CommandAbstract
{
    protected $arguments = array();
    protected static $validArguments;

    /**
     * Executes the command and returns response
     *
     * @return array Response
     * @throws InvalidCommandArgumentException If has any invalid arguments
     */
    public function execute()
    {
        $this->checkArgumentsValid();

        if ($this->hasArgument('--help')) {
            return $this->usage();
        }

        return $this->executeCommand();
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function usage()
    {
        return static::responseMsg('Usage: ' .
            $this->name . ' ' . static::$usage
        );
    }

    public function addArguments($args)
    {
        if (!$args) {
            return $this;
        }

        if (!is_array($args)) {
            $args = array($args);
        }

        $this->arguments = array_merge($this->arguments, $args);

        return $this;
    }

    protected function hasArgument($argument)
    {
        return array_search($argument, $this->arguments) !== false;
    }

    protected function checkArgumentsValid()
    {
        $invalidArgs = array_diff($this->arguments, static::$validArguments);
        if ($invalidArgs) {
            throw new InvalidCommandArgumentException(
                'Invalid command argument: ' . $invalidArgs[0]
            );
        }
    }

    protected static function responseMsg($msg)
    {
        return array('msg' => htmlentities($msg));
    }
}
