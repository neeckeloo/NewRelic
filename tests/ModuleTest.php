<?php

namespace NewRelicTest;

use NewRelic\Client;
use NewRelic\Module;
use NewRelic\ModuleOptions;
use Zend\EventManager\EventManager;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

/**
 * @covers \NewRelic\Module
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /** @var EventManager */
    private $events;

    /** @var ServiceManager */
    private $services;

    /** @var ApplicationInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $application;

    /** @var ListenerAggregateInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $listener;

    /** @var ModuleOptions */
    private $options;

    /** @var Client|\PHPUnit_Framework_MockObject_MockObject */
    private $client;

    /** @var Module */
    private $module;

    protected function setUp()
    {
        $this->client = $this->getMockBuilder(Client::class)->getMock();
        $this->options = new ModuleOptions();
        $this->listener = $this->getMockBuilder(ListenerAggregateInterface::class)->getMock();
        $this->services = new ServiceManager();
        $this->application = $this->getMockBuilder(ApplicationInterface::class)->getMock();
        $this->application->method('getServiceManager')->willReturn($this->services);
        $this->events = new EventManager();
        $this->application->method('getEventManager')->willReturn($this->events);

        $this->module = $module = new Module();
    }

    public function testGetConfig()
    {
        $config = $this->module->getConfig();

        self::assertInternalType('array', $config);

        // Assert there are no closures (which cannot be cached).
        self::assertArraySubset($config, unserialize(serialize($config)));
    }

    public function testGetAutoLoaderConfig()
    {
        $config = $this->module->getAutoloaderConfig();

        self::assertInternalType('array', $config);
    }

    public function testBootstrapBindsListeners()
    {
        $this->listener->expects(self::once())->method('attach');

        $this->client->method('extensionLoaded')->willReturn(true);

        $event = new MvcEvent();
        $event->setApplication($this->application);

        $this->services->setService(Client::class, $this->client);
        $this->services->setService(ModuleOptions::class, $this->options);
        $this->services->setService(ListenerAggregateInterface::class, $this->listener);

        $this->options->setListeners([
            ListenerAggregateInterface::class,
        ]);

        $this->module->onBootstrap($event);
    }

    public function testBootstrapNotBindsListenersDueToMissingExtension()
    {
        $this->listener->expects(self::never())->method('attach');

        $this->client->method('extensionLoaded')->willReturn(false);

        $event = new MvcEvent();
        $event->setApplication($this->application);

        $this->services->setService(Client::class, $this->client);
        $this->services->setService(ModuleOptions::class, $this->options);
        $this->services->setService(ListenerAggregateInterface::class, $this->listener);

        $this->options->setListeners([
            ListenerAggregateInterface::class,
        ]);

        $this->module->onBootstrap($event);
    }
}
