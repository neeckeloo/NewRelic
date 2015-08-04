<?php
namespace NewRelicTest\Factory;

use NewRelic\Log\Writer\NewRelic as LogWriter;
use NewRelic\Factory\LoggerFactory;
use Zend\Log\Logger;
use Zend\ServiceManager\ServiceManager;

class LoggerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggerFactory
     */
    protected $loggerFactory;

    public function setUp()
    {
        $this->loggerFactory = new LoggerFactory();
    }

    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('NewRelic\Log\Writer', new LogWriter());

        $logger = $this->loggerFactory->createService($serviceManager);
        $this->assertInstanceOf(Logger::class, $logger);

        $writers = $logger->getWriters()->toArray();
        $this->assertInstanceOf(LogWriter::class, $writers[0]);
    }
}
