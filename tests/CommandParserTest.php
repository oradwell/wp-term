<?php

require_once __DIR__ . '/../CommandParser.php';

class CommandParserTest extends PHPUnit_Framework_TestCase
{
    protected $parser;

    public function setUp()
    {
        $this->parser = new CommandParser;
    }

    public function testParseReturnsNullWhenNoCommandGiven()
    {
        $this->assertNull($this->parser->parse(''));
        $this->assertNull($this->parser->parse("\t "));
    }

    public function testGetReturnsNullForInvalidCommands()
    {
        $this->assertNull($this->parser->parse('hey')->get());
        $this->assertNull($this->parser->parse('not-a-command')->get());
    }

    /**
     * @dataProvider listCommandProvider
     */
    public function testParsesListCommands($command)
    {
        $parser = $this->parser
            ->parse($command);
        $this->assertInstanceOf('CommandParser', $parser);

        $listCommand = $parser->get();
        $this->assertInstanceOf('CommandAbstract', $listCommand);
        $this->assertInstanceOf('ListCommand', $listCommand);
    }

    public function listCommandProvider()
    {
        return array(
            array('ls'),
            array('list'),
            array('list --pages'),
            array('list --posts'),
            array('list-posts'),
            array('list-pages'),
        );
    }
}
