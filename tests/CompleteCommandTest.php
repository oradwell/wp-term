<?php

use Ockcyp\WpTerm\Command\CompleteCommand;
use Ockcyp\WpTerm\Config\Config;

class CompleteCommandTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Config::get('test');
        $this->completeCommand = new CompleteCommand;
    }

    public function testReturnsAllCommandsForEmptyString()
    {
        $res = $this->completeCommand
            ->execute();

        $this->assertNotEmpty($res);
        $expected = array('list' => array(
            'clear',
            'exit',
            'goto',
            'help',
            'history',
            'list',
        ));
        $this->assertEquals($expected, $res);
    }

    public function testReturnsListEvenWhenThereAreEmptyArgs()
    {
        $res = $this->completeCommand->addArgument('')
            ->addArgument('h')
            ->execute();

        $this->assertNotEmpty($res);
        $expected = array('list' => array(
            'help', // finds hELP
            'history', // finds hISTORY
        ));
        $this->assertEquals($expected, $res);
    }

    public function testListsCommandsForHelpCommand()
    {
        $res = $this->completeCommand->addArgument('help')
            ->addArgument('h')
            ->execute();

        $this->assertNotEmpty($res);
        $expected = array('list' => array(
            'help', // finds hELP
            'history', // finds hISTORY
        ));
        $this->assertEquals($expected, $res);
    }

    public function testReturnsListForMultipleCommandMatches()
    {
        $res = $this->completeCommand->addArgument('h')
            ->execute();

        $this->assertNotEmpty($res);
        $expected = array('list' => array(
            'help', // finds hELP
            'history', // finds hISTORY
        ));
        $this->assertEquals($expected, $res);
    }

    public function testCompletesSingleCommand()
    {
        $res = $this->completeCommand->addArgument('go')
            ->execute();

        $this->assertNotEmpty($res);
        // completes to goTO
        $this->assertEquals(array('complete' => 'to'), $res);
    }

    public function testCompletesSinglePost()
    {
        $args = array('goto', 'ab');
        $res = $this->completeCommand->addArgumentArray($args)
            ->execute();

        $this->assertNotEmpty($res);
        // completes to abOUT
        $this->assertEquals(array('complete' => 'out'), $res);
    }

    public function testGivesAllPosts()
    {
        $args = array('goto', '');
        $res = $this->completeCommand->addArgumentArray($args)
            ->execute();

        $this->assertNotEmpty($res);
        $this->assertArrayHasKey('list', $res);
        // 19 posts in total
        $this->assertEquals(19, count($res['list']));
    }
}
