<?php

namespace NewRelicTest\Factory;

use NewRelic\Client;
use NewRelic\Factory\ResponseListenerFactory;
use NewRelic\Listener\ResponseListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers \NewRelic\Factory\ResponseListenerFactory
 */
class ResponseListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = new ServiceManager();
        $serviceLocator->setService('NewRelic\Client', new Client());
        $serviceLocator->setService('NewRelic\ModuleOptions', new ModuleOptions());

        $factory = new ResponseListenerFactory();

        $listener = $factory->createService($serviceLocator);

        self::assertInstanceOf(ResponseListener::class, $listener);
    }
}
