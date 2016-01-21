<?php
namespace NewRelicTest\Factory;

use NewRelic\ClientInterface;
use NewRelic\Factory\IgnoreApdexListenerFactory;
use NewRelic\Listener\IgnoreApdexListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

class IgnoreApdexListenerFactoryTest extends \PHPUnit_Framework_TestCase
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
            new ModuleOptions()
        );
        $ignoreApdexListenerFactory = new IgnoreApdexListenerFactory();

        $listener = $ignoreApdexListenerFactory($serviceManager);

        $this->assertInstanceOf(IgnoreApdexListener::class, $listener);
    }
}
