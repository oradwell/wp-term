<?php

namespace Ockcyp\WpTerm\Command;

use Ockcyp\WpTerm\Exception\InvalidCommandArgumentException;

abstract class CommandAbstract
{
    /**
     * Usage of the command
     *
     * @var string
     */
    public static $usage;

    /**
     * Command arguments
     *
     * @var array
     */
    protected $arguments = array();

    /**
     * Accepted arguments
     *
     * @var array
     */
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

    /**
     * Change name of the command. Used for command aliases
     *
     * @param string $name New name of the command
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Return the command usage
     *
     * @return array Usage information will be in 'msg' key of the array
     */
    public function usage()
    {
        $msg = 'Usage: ' . $this->name;
        if (static::$usage) {
            $msg .= ' ' . static::$usage;
        }

        return static::responseMsg($msg);
    }

    /**
     * Adds arguments to the command
     *
     * @param string|array $args Arguments to add
     */
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

    /**
     * Check if an argument is given
     *
     * @param  string  $argument Argument
     *
     * @return boolean           True if the argument is given
     */
    protected function hasArgument($argument)
    {
        return array_search($argument, $this->arguments) !== false;
    }

    /**
     * Check if all the given arguments are valid
     *
     * @throws InvalidCommandArgumentException If an invalid argument is given
     */
    protected function checkArgumentsValid()
    {
        $invalidArgs = array_diff($this->arguments, static::$validArguments);
        if ($invalidArgs) {
            throw new InvalidCommandArgumentException(
                'Invalid command argument: ' . $invalidArgs[0]
            );
        }
    }

    /**
     * Prepare the message to be sent
     *
     * @param  string $msg Message
     *
     * @return array       Response
     */
    protected static function responseMsg($msg)
    {
        return array('msg' => htmlentities($msg));
    }
}
