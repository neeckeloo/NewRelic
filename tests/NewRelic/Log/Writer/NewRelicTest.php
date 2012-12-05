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

    public function testSetManager()
    {
        $manager = $this->getMock('NewRelic\Manager', array(), array(), '', false);
        $this->writer->setManager($manager);

        $this->assertInstanceOf('NewRelic\Manager', $this->writer->getManager());
    }
}