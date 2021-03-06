<?php
namespace NewRelicTest\Factory;

use Psr\Container\ContainerInterface;
use NewRelic\ClientInterface;
use NewRelic\Factory\IgnoreTransactionListenerFactory;
use NewRelic\Listener\IgnoreTransactionListener;
use NewRelic\ModuleOptionsInterface;
use PHPUnit\Framework\TestCase;

class IgnoreTransactionListenerFactoryTest extends TestCase
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

        $listener = $ignoreTransactionListenerFactory($container->reveal(), IgnoreTransactionListener::class);
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
