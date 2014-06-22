<?php

abstract class CommandAbstract
{
    protected $arguments = array();

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
}
