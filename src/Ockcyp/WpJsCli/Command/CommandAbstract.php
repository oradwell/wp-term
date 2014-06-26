<?php

namespace Ockcyp\WpJsCli\Command;

use Ockcyp\WpJsCli\Exception\InvalidCommandArgumentException;

abstract class CommandAbstract
{
    protected $arguments = array();
    protected static $validArguments;

    abstract public function execute();

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
}
