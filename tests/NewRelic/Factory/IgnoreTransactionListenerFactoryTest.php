<?php
namespace NewRelic\Factory;

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
        $serviceManager->setService('NewRelic\ModuleOptions', new ModuleOptions());

        $listener = $this->ignoreTransactionListenerFactory->createService($serviceManager);
        $this->assertInstanceOf('NewRelic\Listener\IgnoreTransactionListener', $listener);
    }
}