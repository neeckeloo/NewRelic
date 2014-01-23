<?php
namespace NewRelic\Service;

class BackgroundJobListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BackgroundJobListenerFactory
     */
    protected $backgroundJobListenerFactory;

    public function setUp()
    {
        $this->backgroundJobListenerFactory = new BackgroundJobListenerFactory();
    }

    public function testCreateService()
    {
        $moduleOptions = $this->getMock('NewRelic\ModuleOptions');
        $moduleOptions
            ->expects($this->once())
            ->method('getBackgroundJobs')
            ->will($this->returnValue(array()));

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($moduleOptions));

        $listener = $this->backgroundJobListenerFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Listener\BackgroundJobListener', $listener);
    }
}