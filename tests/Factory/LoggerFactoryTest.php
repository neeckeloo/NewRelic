<?php
namespace NewRelicTest\Factory;

use NewRelic\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateServiceShouldReturnPsrLoggerInstance()
    {
        $loggerFactory = new LoggerFactory();

        $logger = $loggerFactory();

        $this->assertInstanceOf(LoggerInterface::class, $logger);
    }
}
