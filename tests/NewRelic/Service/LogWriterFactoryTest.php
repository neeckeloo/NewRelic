<?php
namespace NewRelic\Service;

class LogWriterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogWriterFactory
     */
    protected $logWriterFactory;

    public function setUp()
    {
        $this->logWriterFactory = new LogWriterFactory();
    }

    public function testCreateService()
    {
        $manager = $this->getMock('NewRelic\Manager', array(), array(), '', false);

        $serviceManager = $this->getMock(
            'Zend\ServiceManager\ServiceManager',
            array('get'), array(), '', false
        );

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($manager));

        $writer = $this->logWriterFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Log\Writer\NewRelic', $writer);
    }
}