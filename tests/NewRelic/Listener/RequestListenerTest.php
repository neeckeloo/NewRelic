<?php
namespace NewRelic\Listener;

use NewRelic\Client;
use NewRelic\ModuleOptions;
use Zend\Mvc\MvcEvent;

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
        
        $this->client = $this->getMock('NewRelic\Client', array(), array(), '', false);
        $this->client
            ->expects($this->any())
            ->method('setAppName');
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

        $routeMatch = new \Zend\Mvc\Router\RouteMatch(array());
        $this->event->setRouteMatch($routeMatch);

        $this->listener->onRequest($this->event);
    }

    public function testAppNameNotSetWhenMissingInConfig()
    {
        $this->moduleOptions->setApplicationName("");

        $this->client
            ->expects($this->never())
            ->method('setAppName');

        $routeMatch = new \Zend\Mvc\Router\RouteMatch(array());
        $this->event->setRouteMatch($routeMatch);

        $this->listener->onRequest($this->event);
    }
}
