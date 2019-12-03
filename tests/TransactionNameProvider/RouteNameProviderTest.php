<?php
namespace NewRelicTest\TransactionNameProvider;

use NewRelic\TransactionNameProvider\RouteNameProvider;
use PHPUnit\Framework\TestCase;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch as RouteMatchV2;
use Zend\Router\RouteMatch;

class RouteNameProviderTest extends TestCase
{
    public function testGetTransactionNameFromMvcEventWithoutRouteMatchShouldReturnNull()
    {
        $routeNameProvider = new RouteNameProvider();

        if (class_exists(RouteMatchV2::class)) {
            $routeMatch = new RouteMatchV2([]);
        } else {
            $routeMatch = new RouteMatch([]);
        }

        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);

        $transactionName = $routeNameProvider->getTransactionName($event);

        $this->assertNull($transactionName);
    }

    public function testGetTransactionNameFromMvcEventWithRouteMatchShouldReturnRouteName()
    {
        $routeName = 'foo';
        $routeNameProvider = new RouteNameProvider();

        if (class_exists(RouteMatchV2::class)) {
            $routeMatch = new RouteMatchV2([]);
        } else {
            $routeMatch = new RouteMatch([]);
        }

        $routeMatch->setMatchedRouteName($routeName);

        $event = new MvcEvent();
        $event->setRouteMatch($routeMatch);

        $transactionName = $routeNameProvider->getTransactionName($event);

        $this->assertEquals($transactionName, $routeName);
    }
}
