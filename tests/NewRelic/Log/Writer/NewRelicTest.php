<?php
namespace NewRelic\Log\Writer;

class NewRelicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NewRelic
     */
    protected $writer;

    public function setUp()
    {
        $this->writer = new NewRelic();
    }

    public function testSetClient()
    {
        $client = $this->getMock('NewRelic\Client', array(), array(), '', false);
        $this->writer->setClient($client);

        $this->assertInstanceOf('NewRelic\Client', $this->writer->getClient());
    }
}