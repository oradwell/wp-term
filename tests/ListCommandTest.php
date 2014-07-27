<?php

use Ockcyp\WpTerm\Command\ListCommand;

class ListCommandTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->listCommand = new ListCommand;
    }

    public function testReturnsListOnExecute()
    {
        $response = $this->listCommand->execute();

        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response['list']);
    }

    /**
     * @expectedException Ockcyp\WpTerm\Exception\InvalidCommandArgumentException
     */
    public function testGivesInvalidArgumentException()
    {
        $this->listCommand->addArgument('--invalid-argument')
            ->execute();
    }

    public function testReturnsPagesOnly()
    {
        $response = $this->listCommand->addArgument('--pages')
            ->execute();

        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response['list']);
        $this->assertEquals(
            array(
                'about',
                'my-work',
                'contact',
            ),
            $response['list']
        );
    }

    public function testReturnsUsage()
    {
        $response = $this->listCommand->addArgument('--help')
            ->execute();

        $expected = array('msg' => 'Usage: list [--pages|--posts]');
        $this->assertEquals($expected, $response);
    }

    public function testDoesNotReturnPages()
    {
        $response = $this->listCommand->addArgument('--posts')
            ->execute();

        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response['list']);

        $this->assertArrayNotHasKey('about', $response['list']);
        $this->assertArrayNotHasKey('my-work', $response['list']);
        $this->assertArrayNotHasKey('contact', $response['list']);
    }
}
