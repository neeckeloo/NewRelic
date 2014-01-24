<?php
namespace NewRelic\Service;

class IgnoreTransactionListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IgnoreTransactionListenerFactory
     */
    protected $ignoreTransactionListenerFactory;

    public function setUp()
    {
        $this->ignoreTransactionListenerFactory = new IgnoreTransactionListenerFactory();
    }

    public function testCreateService()
    {
        $moduleOptions = $this->getMock('NewRelic\ModuleOptions');
        $moduleOptions
            ->expects($this->once())
            ->method('getIgnoredTransactions')
            ->will($this->returnValue(array()));

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($moduleOptions));

        $listener = $this->ignoreTransactionListenerFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Listener\IgnoreTransactionListener', $listener);
    }
}