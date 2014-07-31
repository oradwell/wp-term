<?php

use Ockcyp\WpTerm\Parser\Command as CommandParser;

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

    public function testIgnoresWhitespaceAtTheBeginning()
    {
        $parser = $this->parser->parse(" \t list");

        $listCommand = $parser->get();
        $this->assertInstanceOf('Ockcyp\WpTerm\Command\CommandAbstract', $listCommand);
        $this->assertInstanceOf('Ockcyp\WpTerm\Command\ListCommand', $listCommand);
    }

    /**
     * @dataProvider listCommandProvider
     */
    public function testParsesListCommands($command)
    {
        $parser = $this->parser
            ->parse($command);
        $this->assertInstanceOf('Ockcyp\WpTerm\Parser\Command', $parser);

        $listCommand = $parser->get();
        $this->assertInstanceOf('Ockcyp\WpTerm\Command\CommandAbstract', $listCommand);
        $this->assertInstanceOf('Ockcyp\WpTerm\Command\ListCommand', $listCommand);
    }

    public function testParsesGotoCommand()
    {
        $parser = $this->parser
            ->parse('goto about');
        $this->assertInstanceOf('Ockcyp\WpTerm\Parser\Command', $parser);

        $gotoCommand = $parser->get();
        $this->assertInstanceOf('Ockcyp\WpTerm\Command\CommandAbstract', $gotoCommand);
        $this->assertInstanceOf('Ockcyp\WpTerm\Command\GotoCommand', $gotoCommand);
    }

    public function testParsesHelpCommand()
    {
        $parser = $this->parser
            ->parse('help help');
        $this->assertInstanceOf('Ockcyp\WpTerm\Parser\Command', $parser);

        $helpCommand = $parser->get();
        $this->assertInstanceOf('Ockcyp\WpTerm\Command\CommandAbstract', $helpCommand);
        $this->assertInstanceOf('Ockcyp\WpTerm\Command\HelpCommand', $helpCommand);
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
