<?php
namespace NewRelicTest\Factory;

use NewRelic\ClientInterface;
use NewRelic\Factory\BackgroundJobListenerFactory;
use NewRelic\Listener\BackgroundJobListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

class BackgroundJobListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(
            'NewRelic\Client',
            $this->createMock(ClientInterface::class)
        );
        $serviceManager->setService(
            'NewRelic\ModuleOptions',
            new ModuleOptions()
        );
        $backgroundJobListenerFactory = new BackgroundJobListenerFactory();

        $listener = $backgroundJobListenerFactory($serviceManager);

        $this->assertInstanceOf(BackgroundJobListener::class, $listener);
    }
}
