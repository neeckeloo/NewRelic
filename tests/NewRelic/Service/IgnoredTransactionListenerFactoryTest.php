<?php
namespace NewRelic\Service;

class IgnoredTransactionListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IgnoredTransactionListenerFactory
     */
    protected $ignoredTransactionListenerFactory;

    public function setUp()
    {
        $this->ignoredTransactionListenerFactory = new IgnoredTransactionListenerFactory();
    }

    public function testCreateService()
    {
        $client = $this->getMockBuilder('NewRelic\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $moduleOptions = $this->getMock('NewRelic\ModuleOptions');
        $moduleOptions
            ->expects($this->once())
            ->method('getIgnoredTransactions')
            ->will($this->returnValue(array()));

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        $serviceManager->expects($this->at(0))
            ->method('get')
            ->will($this->returnValue($client));

        $serviceManager->expects($this->at(1))
            ->method('get')
            ->will($this->returnValue($moduleOptions));

        $listener = $this->ignoredTransactionListenerFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Listener\IgnoredTransactionListener', $listener);
    }
}