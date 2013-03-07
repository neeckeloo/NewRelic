<?php
namespace NewRelic\Listener;

use NewRelic\Configuration;
use NewRelic\Client;
use Zend\Mvc\MvcEvent;

class RequestListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var MvcEvent
     */
    protected $event;

    public function setUp()
    {
        $this->configuration = new Configuration();

        $this->client = $this->getMock('NewRelic\Client', array(), array(), '', false);
        $this->client
            ->expects($this->any())
            ->method('getConfiguration')
            ->will($this->returnValue($this->configuration));
        $this->client
            ->expects($this->any())
            ->method('setAppName');

        $this->listener = new RequestListener($this->client);
        $this->event    = new MvcEvent();
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
}