<?php

use Ockcyp\WpTerm\Command\GotoCommand;

class GotoCommandTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->gotoCommand = new GotoCommand;
    }

    /**
     * @expectedException Ockcyp\WpTerm\Exception\MissingCommandArgumentException
     */
    public function testGivesMissingCommandArgumentException()
    {
        $this->gotoCommand->execute();
    }

    public function testReturnsNullWhenPostNotFound()
    {
        $res = $this->gotoCommand->addArgument('about')
            ->execute();

        $this->assertNotEmpty($res);
        $this->assertEquals('http://www.ockwebs.com/about/', $res['url']);
    }

    /**
     * @expectedException Ockcyp\WpTerm\Exception\PostNotFoundException
     */
    public function testReturnsPostUrl()
    {
        $res = $this->gotoCommand->addArgument('not-a-post')
            ->execute();
    }
}
