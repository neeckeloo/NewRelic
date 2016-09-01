<?php
namespace NewRelicTest;

use NewRelic\TransactionMatcher;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;
use Zend\Mvc\Router\RouteMatch as RouteMatchV2;

class TransactionMatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $currentRoute = 'foo/bar';

    /**
     * @var string
     */
    protected $currentController = 'FooController';

    /**
     * @var string
     */
    protected $currentAction = 'foo';

    /**
     * @dataProvider transactionProvider
     */
    public function testIsMatched($transactions, $isMatched)
    {
        $routeMatch = $this->getRouteMatch();
        $transactionMatcher = new TransactionMatcher($transactions);

        $mvcEvent = $this->prophesize(MvcEvent::class);
        $mvcEvent->getRouteMatch()->shouldBeCalled()->willReturn($routeMatch);

        $this->assertSame($isMatched, $transactionMatcher->isMatched($mvcEvent->reveal()));
    }

    public function transactionProvider()
    {
        return [
            // Client method called
            [
                ['routes' => ['foo/bar']],
                true,
            ],
            [
                ['routes' => ['foo*']],
                true,
            ],
            [
                ['routes' => ['*']],
                true,
            ],
            [
                ['controllers' => [
                    'FooController'
                ]],
                true,
            ],
            [
                ['controllers' => [
                    ['FooController', ['foo']]
                ]],
                true,
            ],

            // Client method avoided
            [
                ['routes' => ['bar/foo']],
                false,
            ],
            [
                ['controllers' => [
                    'BarController'
                ]],
                false,
            ],
            [
                ['controllers' => [
                    ['FooController', ['bar']]
                ]],
                false,
            ],
        ];
    }

    /**
     * @return RouteMatch
     */
    private function getRouteMatch()
    {
        $routeMatch = $this->getMockBuilder(class_exists(RouteMatch::class) ? RouteMatch::class : RouteMatchV2::class)
            ->disableOriginalConstructor()
            ->getMock();

        $routeMatch
            ->expects($this->any())
            ->method('getMatchedRouteName')
            ->will($this->returnValue($this->currentRoute));

        $controller = $this->currentController;
        $action = $this->currentAction;
        $callback = function($name) use ($controller, $action) {
            if ($name == 'controller') {
                return $controller;
            }
            if ($name == 'action') {
                return $action;
            }
        };

        $routeMatch
            ->expects($this->any())
            ->method('getParam')
            ->will($this->returnCallback($callback));

        return $routeMatch;
    }
}
