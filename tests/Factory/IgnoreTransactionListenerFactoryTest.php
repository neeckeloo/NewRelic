<?php
namespace NewRelicTest\Factory;

use NewRelic\ClientInterface;
use NewRelic\Factory\IgnoreTransactionListenerFactory;
use NewRelic\Listener\IgnoreTransactionListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

class IgnoreTransactionListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'NewRelic\Client',
            $this->createMock(ClientInterface::class)
        );
        $serviceManager->setService(
            'NewRelic\ModuleOptions',
            new ModuleOptions()
        );
        $ignoreTransactionListenerFactory = new IgnoreTransactionListenerFactory();

        $listener = $ignoreTransactionListenerFactory($serviceManager);
        $this->assertInstanceOf(IgnoreTransactionListener::class, $listener);
    }
}
