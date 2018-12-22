<?php
namespace NewRelicTest\Listener;

use NewRelic\ClientInterface;
use NewRelic\Listener\RequestListener;
use NewRelic\ModuleOptions;
use PHPUnit\Framework\TestCase;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;
use Zend\Mvc\Router\RouteMatch as RouteMatchV2;

class RequestListenerTest extends TestCase
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var ClientInterface
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
        $this->client = $this->createMock(ClientInterface::class);
        $this->moduleOptions = new ModuleOptions();
        $this->listener = new RequestListener($this->client, $this->moduleOptions);

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

        $routeMatch = class_exists(RouteMatch::class) ? new RouteMatch([]) : new RouteMatchV2([]);
        $this->event->setRouteMatch($routeMatch);

        $this->listener->onRequest($this->event);
    }

    public function testAppNameNotSetWhenMissingInConfig()
    {
        $this->moduleOptions->setApplicationName('');

        $this->client
            ->expects($this->never())
            ->method('setAppName');

        $routeMatch = class_exists(RouteMatch::class) ? new RouteMatch([]) : new RouteMatchV2([]);
        $this->event->setRouteMatch($routeMatch);

        $this->listener->onRequest($this->event);
    }
}
