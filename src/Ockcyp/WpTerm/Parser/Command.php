<?php

namespace Ockcyp\WpTerm\Parser;

use Ockcyp\WpTerm\Command\CommandFactory;
use Ockcyp\WpTerm\Exception\InvalidCommandException;

class Command
{
    /**
     * Name of the command executable
     *
     * @var string
     */
    protected $executable;

    /**
     * List of arguments
     *
     * @var array
     */
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
                ->addArgumentArray($this->arguments);
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

        // Ignore white-space at the beginning
        $command = ltrim($command);

        $args = explode(' ', $command);
        foreach ($args as &$arg) {
            $arg = trim($arg);
        }

        return $args;
    }
}
