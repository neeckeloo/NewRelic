<?php
namespace NewRelicTest\Listener;

use NewRelic\Client;
use NewRelic\Listener\RequestListener;
use NewRelic\ModuleOptions;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class RequestListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var RequestListener
     */
    protected $listener;

    /**
     * @var MvcEvent
     */
    protected $event;

    public function setUp()
    {
        $this->listener = new RequestListener();

        $this->moduleOptions = new ModuleOptions();
        $this->listener->setModuleOptions($this->moduleOptions);

        $this->client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->listener->setClient($this->client);

        $this->event = new MvcEvent();
    }

    public function testOnRequestWithoutRouteMatch()
    {
        $this->client
            ->expects($this->never())
            ->method('nameTransaction');

        $this->listener->onRequest($this->event);
    }

    public function testOnRequestWithRouteMatch()
    {
        $this->client
            ->expects($this->once())
            ->method('nameTransaction');

        $routeMatch = new RouteMatch([]);
        $this->event->setRouteMatch($routeMatch);

        $this->listener->onRequest($this->event);
    }

    public function testAppNameNotSetWhenMissingInConfig()
    {
        $this->moduleOptions->setApplicationName('');

        $this->client
            ->expects($this->never())
            ->method('setAppName');

        $routeMatch = new RouteMatch([]);
        $this->event->setRouteMatch($routeMatch);

        $this->listener->onRequest($this->event);
    }
}
