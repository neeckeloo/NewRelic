<?php
namespace NewRelic\Service;

class IgnoreApdexListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IgnoreApdexListenerFactory
     */
    protected $ignoreApdexListenerFactory;

    public function setUp()
    {
        $this->ignoreApdexListenerFactory = new IgnoreApdexListenerFactory();
    }

    public function testCreateService()
    {
        $moduleOptions = $this->getMock('NewRelic\ModuleOptions');
        $moduleOptions
            ->expects($this->once())
            ->method('getIgnoredApdex')
            ->will($this->returnValue(array()));

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($moduleOptions));

        $listener = $this->ignoreApdexListenerFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Listener\IgnoreApdexListener', $listener);
    }
}