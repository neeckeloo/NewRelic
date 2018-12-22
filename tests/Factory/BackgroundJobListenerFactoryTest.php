<?php
namespace NewRelicTest\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\ClientInterface;
use NewRelic\Factory\BackgroundJobListenerFactory;
use NewRelic\Listener\BackgroundJobListener;
use NewRelic\ModuleOptionsInterface;
use PHPUnit\Framework\TestCase;

class BackgroundJobListenerFactoryTest extends TestCase
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
        $backgroundJobListenerFactory = new BackgroundJobListenerFactory();

        $listener = $backgroundJobListenerFactory($container->reveal(), BackgroundJobListener::class);

        $this->assertInstanceOf(BackgroundJobListener::class, $listener);
    }

    private function getModuleOptions()
    {
        $moduleOptions = $this->prophesize(ModuleOptionsInterface::class);
        $moduleOptions->getBackgroundJobs()->willReturn([]);

        return $moduleOptions->reveal();
    }

    private function getClient()
    {
        return $this->prophesize(ClientInterface::class)->reveal();
    }
}
