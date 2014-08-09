<?php

use Ockcyp\WpTerm\Config\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testGetsConfig()
    {
        Config::clear();

        $this->assertNotEmpty(Config::get('test'));
        $this->assertEquals('test', Config::getEnv());
    }

    public function testResetsEnvironment()
    {
        Config::get('test');
        Config::getEnv();

        Config::clear();
        $this->assertNull(Config::getEnv());
    }
}
