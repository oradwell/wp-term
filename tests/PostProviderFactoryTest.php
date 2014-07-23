<?php

use Ockcyp\WpTerm\PostProvider\PostProviderFactory;
use Ockcyp\WpTerm\Config\Config;

class PostProviderFactoryTest extends PHPUnit_Framework_TestCase
{
    public $config;

    public function setUp()
    {
        $this->config = Config::get('test');
    }

    public function testMakesDatabasePostProvider()
    {
        $this->config['post_src'] = 'post_src_db';

        PostProviderFactory::setConfig($this->config);

        $response = PostProviderFactory::make();

        $this->assertInstanceOf('Ockcyp\WpTerm\PostProvider\Database', $response);
    }

    public function testMakesFilePostProvider()
    {
        $this->config['post_src'] = 'post_src_file';

        PostProviderFactory::setConfig($this->config);

        $response = PostProviderFactory::make();

        $this->assertInstanceOf('Ockcyp\WpTerm\PostProvider\File', $response);
    }

    /**
     * @expectedException Ockcyp\WpTerm\Exception\UnsupportedPostSourceTypeException
     */
    public function testThrowsUnsupportedPostSourceTypeException()
    {
        $this->config['post_src'] = 'post_src_asd';
        $this->config['post_src_asd']['type'] = 'asd';

        PostProviderFactory::setConfig($this->config);
        PostProviderFactory::make();
    }
}
