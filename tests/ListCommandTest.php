<?php

use Ockcyp\WpJsCli\Command\ListCommand;

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
     * @expectedException Ockcyp\WpJsCli\Exception\InvalidCommandArgumentException
     */
    public function testGivesInvalidArgumentException()
    {
        $this->listCommand->addArguments('--invalid-argument')
            ->execute();
    }

    public function testReturnsPagesOnly()
    {
        $response = $this->listCommand->addArguments('--pages')
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

    public function testDoesNotReturnPages()
    {
        $response = $this->listCommand->addArguments('--posts')
            ->execute();

        $this->assertNotEmpty($response);
        $this->assertNotEmpty($response['list']);

        $this->assertArrayNotHasKey('about', $response['list']);
        $this->assertArrayNotHasKey('my-work', $response['list']);
        $this->assertArrayNotHasKey('contact', $response['list']);
    }
}