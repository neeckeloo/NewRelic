<?php
namespace NewRelic\Service;

class ErrorListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ErrorListenerFactory
     */
    protected $errorListenerFactory;

    public function setUp()
    {
        $this->errorListenerFactory = new ErrorListenerFactory();
    }

    public function testCreateService()
    {
        $configuration = $this->getMock('NewRelic\Configuration');

        $client = $this->getMockBuilder('NewRelic\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $logger = $this->getMock('Zend\Log\Logger');

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        $serviceManager->expects($this->at(0))
            ->method('get')
            ->will($this->returnValue($configuration));

        $serviceManager->expects($this->at(1))
            ->method('get')
            ->will($this->returnValue($client));

        $serviceManager->expects($this->at(2))
            ->method('get')
            ->will($this->returnValue($logger));

        $listener = $this->errorListenerFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Listener\ErrorListener', $listener);
    }
}