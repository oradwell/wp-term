<?php

namespace Ockcyp\WpPostsCli\Parser;

use Ockcyp\WpPostsCli\Command\CommandFactory;
use Ockcyp\WpPostsCli\Exception\InvalidCommandException;

class Command
{
    protected $executable;
    protected $arguments;

    /**
     * Parse the command
     *
     * @param  string $command Command
     *
     * @return Command
     */
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

    /**
     * Get the parsed command
     *
     * @return CommandAbstract The command
     */
    public function get()
    {
        try {
            return CommandFactory::make($this->executable)
                ->addArguments($this->arguments);
        } catch (InvalidCommandException $e) {
            return null;
        }
    }

    /**
     * Splits the arguments using the white space
     *
     * @param  string $command Command
     *
     * @return array           List of arguments
     */
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
