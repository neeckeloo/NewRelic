<?php
namespace NewRelicTest;

use NewRelic\TransactionMatcher;
use Zend\Mvc\Router\RouteMatch;

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

        $this->assertSame($isMatched, $transactionMatcher->isMatched($routeMatch));
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
        $routeMatch = $this->getMockBuilder(RouteMatch::class)
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
