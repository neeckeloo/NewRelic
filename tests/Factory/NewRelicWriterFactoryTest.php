<?php
namespace NewRelicTest\Factory;

use NewRelic\ClientInterface;
use NewRelic\Factory\NewRelicWriterFactory;
use NewRelic\Log\Writer\NewRelic as NewRelicWriter;
use Zend\ServiceManager\ServiceManager;

class NewRelicWriterFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateServiceShouldReturnPsrLoggerInstance()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'NewRelic\Client',
            $this->getMock(ClientInterface::class)
        );
        $writerFactory = new NewRelicWriterFactory();

        $writer = $writerFactory($serviceManager);

        $this->assertInstanceOf(NewRelicWriter::class, $writer);
    }
}
