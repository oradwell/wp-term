<?php

namespace Ockcyp\WpTerm\Command;

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
}
