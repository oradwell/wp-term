<?php

use Ockcyp\WpPostsCli\Command\GotoCommand;

class GotoCommandTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->gotoCommand = new GotoCommand;
    }

    /**
     * @expectedException Ockcyp\WpPostsCli\Exception\MissingCommandArgumentException
     */
    public function testGivesMissingCommandArgumentException()
    {
        $this->gotoCommand->execute();
    }

    public function testReturnsNullWhenPostNotFound()
    {
        $res = $this->gotoCommand->addArguments('about')
            ->execute();

        $this->assertNotEmpty($res);
        $this->assertEquals('http://www.ockwebs.com/about/', $res['url']);
    }

    public function testReturnsPostUrl()
    {
        $res = $this->gotoCommand->addArguments('not-a-post')
            ->execute();

        $this->assertNull($res);
    }
}
