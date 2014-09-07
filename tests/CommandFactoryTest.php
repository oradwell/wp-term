<?php

use Ockcyp\WpTerm\Command\CommandFactory;

class CommandFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testThrowsRuntimeException()
    {
        CommandFactory::$commandAliasMap['asd'] = array();

        CommandFactory::make('asd');
    }  
}
