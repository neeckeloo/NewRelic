<?php
namespace NewRelicTest\Factory;

use NewRelic\Client;
use NewRelic\Factory\ResponseListenerFactory;
use NewRelic\Listener\ResponseListener;
use NewRelic\ModuleOptions;
use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

class ResponseListenerFactoryTest extends TestCase
{
    public function testCreateService(): void
    {
        $container = $this->prophesize(ContainerInterface::class);
        $client = $this->prophesize(Client::class);
        $options = $this->prophesize(ModuleOptions::class);

        $container->get(Client::class)
            ->shouldBeCalled()
            ->willReturn($client->reveal());
        $container->get(ModuleOptions::class)
            ->shouldBeCalled()
            ->willReturn($options->reveal());

        $factory = new ResponseListenerFactory();
        $service = $factory($container->reveal());

        $this->assertInstanceOf(ResponseListener::class, $service);
    }
}
