<?php
namespace NewRelicTest\Factory;

use NewRelic\Factory\IgnoreTransactionListenerFactory;
use NewRelic\Listener\IgnoreTransactionListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

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
        $serviceManager = new ServiceManager();
        $serviceManager->setService(ModuleOptions::class, new ModuleOptions());

        $listener = $this->ignoreTransactionListenerFactory->createService($serviceManager);
        $this->assertInstanceOf(IgnoreTransactionListener::class, $listener);
    }
}
