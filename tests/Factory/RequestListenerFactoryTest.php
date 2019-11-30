<?php

namespace NewRelicTest\Factory;

use NewRelic\Client;
use NewRelic\Factory\RequestListenerFactory;
use NewRelic\Listener\RequestListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers \NewRelic\Factory\RequestListenerFactory
 */
class RequestListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = new ServiceManager();
        $serviceLocator->setService('NewRelic\Client', new Client());
        $serviceLocator->setService('NewRelic\ModuleOptions', new ModuleOptions());

        $factory = new RequestListenerFactory();

        $listener = $factory->createService($serviceLocator);

        self::assertInstanceOf(RequestListener::class, $listener);
    }
}
