<?php
namespace NewRelicTest\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Factory\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
{
    public function testCreateServiceShouldReturnPsrLoggerInstance()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $loggerFactory = new LoggerFactory();

        $logger = $loggerFactory($container->reveal(), LoggerInterface::class);

        $this->assertInstanceOf(LoggerInterface::class, $logger);
    }
}
