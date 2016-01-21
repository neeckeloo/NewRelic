<?php
namespace NewRelicTest\Factory;

use NewRelic\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use Zend\Log\Writer\WriterInterface;
use Zend\ServiceManager\ServiceManager;

class LoggerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateServiceShouldReturnPsrLoggerInstance()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'NewRelic\Log\Writer',
            $this->getMock(WriterInterface::class)
        );
        $loggerFactory = new LoggerFactory();

        $psrLogger = $loggerFactory($serviceManager);

        $this->assertInstanceOf(LoggerInterface::class, $psrLogger);
    }
}
