<?php
namespace NewRelicTest\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\ClientInterface;
use NewRelic\Factory\IgnoreTransactionListenerFactory;
use NewRelic\Listener\IgnoreTransactionListener;
use NewRelic\ModuleOptionsInterface;

class IgnoreTransactionListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->get('NewRelic\Client')->willReturn(
            $this->getClient()
        );
        $container->get('NewRelic\ModuleOptions')->willReturn(
            $this->getModuleOptions()
        );
        $ignoreTransactionListenerFactory = new IgnoreTransactionListenerFactory();

        $listener = $ignoreTransactionListenerFactory($container->reveal());
        $this->assertInstanceOf(IgnoreTransactionListener::class, $listener);
    }

    private function getModuleOptions()
    {
        $moduleOptions = $this->prophesize(ModuleOptionsInterface::class);
        $moduleOptions->getIgnoredTransactions()->willReturn([]);

        return $moduleOptions->reveal();
    }

    private function getClient()
    {
        return $this->prophesize(ClientInterface::class)->reveal();
    }
}
