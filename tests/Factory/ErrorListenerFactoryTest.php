<?php
namespace NewRelicTest\Factory;

use NewRelic\ClientInterface;
use NewRelic\Factory\ErrorListenerFactory;
use NewRelic\Listener\ErrorListener;
use NewRelic\ModuleOptionsInterface;
use Psr\Log\LoggerInterface;
use Zend\ServiceManager\ServiceManager;

class ErrorListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'NewRelic\Client',
            $this->getMock(ClientInterface::class)
        );
        $serviceManager->setService(
            'NewRelic\ModuleOptions',
            $this->getMock(ModuleOptionsInterface::class)
        );
        $serviceManager->setService(
            'NewRelic\Logger',
            $this->getMock(LoggerInterface::class)
        );
        $errorListenerFactory = new ErrorListenerFactory();

        $listener = $errorListenerFactory($serviceManager);

        $this->assertInstanceOf(ErrorListener::class, $listener);
    }
}
