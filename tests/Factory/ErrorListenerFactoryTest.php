<?php
namespace NewRelicTest\Factory;

use NewRelic\Factory\ErrorListenerFactory;
use NewRelic\Listener\ErrorListener;
use Psr\Log\LoggerInterface;;
use Zend\ServiceManager\ServiceManager;

class ErrorListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'NewRelic\Logger',
            $this->getMock(LoggerInterface::class)
        );
        $errorListenerFactory = new ErrorListenerFactory();

        $listener = $errorListenerFactory->createService($serviceManager);

        $this->assertInstanceOf(ErrorListener::class, $listener);
    }
}
