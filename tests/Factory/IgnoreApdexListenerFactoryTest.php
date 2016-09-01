<?php
namespace NewRelicTest\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\ClientInterface;
use NewRelic\Factory\IgnoreApdexListenerFactory;
use NewRelic\Listener\IgnoreApdexListener;
use NewRelic\ModuleOptionsInterface;

class IgnoreApdexListenerFactoryTest extends \PHPUnit_Framework_TestCase
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
        $ignoreApdexListenerFactory = new IgnoreApdexListenerFactory();

        $listener = $ignoreApdexListenerFactory($container->reveal(), IgnoreApdexListener::class);

        $this->assertInstanceOf(IgnoreApdexListener::class, $listener);
    }

    private function getModuleOptions()
    {
        $moduleOptions = $this->prophesize(ModuleOptionsInterface::class);
        $moduleOptions->getIgnoredApdex()->willReturn([]);

        return $moduleOptions->reveal();
    }

    private function getClient()
    {
        return $this->prophesize(ClientInterface::class)->reveal();
    }
}
