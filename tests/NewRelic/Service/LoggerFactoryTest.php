<?php
namespace NewRelic\Service;

class LoggerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggerFactory
     */
    protected $loggerFactory;

    public function setUp()
    {
        $this->loggerFactory = new LoggerFactory();
    }

    public function testCreateService()
    {
        $writer = $this->getMock('NewRelic\Log\Writer\NewRelic', array(), array(), '', false);

        $serviceManager = $this->getMock(
            'Zend\ServiceManager\ServiceManager',
            array('get'), array(), '', false
        );

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($writer));

        $logger = $this->loggerFactory->createService($serviceManager);

        $this->assertInstanceOf('Zend\Log\Logger', $logger);

        $writers = $logger->getWriters()->toArray();
        $this->assertInstanceOf('NewRelic\Log\Writer\NewRelic', $writers[0]);
    }
}
