<?php

use Ockcyp\WpJsCli\Command\GotoCommand;

class GotoCommandTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->gotoCommand = new GotoCommand;
    }

    /**
     * @expectedException Ockcyp\WpJsCli\Exception\MissingCommandArgumentException
     */
    public function testGivesMissingCommandArgumentException()
    {
        $this->gotoCommand->execute();
    }
}
