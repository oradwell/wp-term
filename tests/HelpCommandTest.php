<?php

use Ockcyp\WpPostsCli\Command\HelpCommand;

class HelpCommandTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->helpCommand = new HelpCommand;
    }

    public function testReturnsList()
    {
        $response = $this->helpCommand
            ->execute();

        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response['list']);
        $this->assertInternalType('array', $response['list']);
    }

    public function testReturnsItsOwnUsage()
    {
        $response = $this->helpCommand
            ->addArguments('help')
            ->execute();

        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response['msg']);
    }
}
