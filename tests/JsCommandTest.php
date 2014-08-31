<?php

use Ockcyp\WpTerm\Command\JsCommand;

class JsCommandTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Ockcyp\WpTerm\Exception\CommandNotExecutableException
     */
    public function testThrowsRuntimeException()
    {
        $jsCommand = new JsCommand('history');
        $jsCommand->execute();
    }
}
