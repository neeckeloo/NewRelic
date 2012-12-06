<?php
namespace NewRelic;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        $configuration = $this->getMockedConfiguration();

        $this->client = new Client($configuration);
    }

    protected function getMockedConfiguration()
    {
        return $this->getMock('NewRelic\Configuration', array(), array(), '', false);
    }

    public function testSetConfiguration()
    {
        $configuration = $this->getMockedConfiguration();
        $this->client->setConfiguration($configuration);

        $this->assertInstanceOf('NewRelic\Configuration', $this->client->getConfiguration());
    }
}