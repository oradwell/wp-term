<?php

namespace Ockcyp\WpJsCli\Parser;

use Ockcyp\WpJsCli\Command\CommandFactory;
use Ockcyp\WpJsCli\Exception\InvalidCommandException;

class Command
{
    protected $executable;
    protected $arguments;

    public function parse($command)
    {
        $args = $this->splitArgs($command);
        if (!$args) {
            return null;
        }

        $this->executable = array_shift($args);
        $this->arguments = $args;

        return $this;
    }

    public function get()
    {
        try {
            return CommandFactory::make($this->executable)
                ->addArguments($this->arguments);
        } catch (InvalidCommandException $e) {
            return null;
        }
    }

    protected function splitArgs($command)
    {
        if (!trim($command)) {
            return array();
        }

        $args = explode(' ', $command);
        foreach ($args as &$arg) {
            $arg = trim($arg);
        }

        return $args;
    }
}
