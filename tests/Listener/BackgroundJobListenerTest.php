<?php
namespace NewRelicTest\Listener;

use NewRelic\Client;
use NewRelic\ClientInterface;
use NewRelic\Listener\BackgroundJobListener;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class BackgroundJobListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface
     */
    protected $client;

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

    public function setUp()
    {
        $this->client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['backgroundJob'])
            ->getMock();
    }

    /**
     * @param  array $transactions
     * @return BackgroundJobListener
     */
    protected function getListener($transactions = [])
    {
        $listener = new BackgroundJobListener($transactions);
        $listener->setClient($this->client);

        return $listener;
    }

    /**
     * @return MvcEvent
     */
    protected function getEvent()
    {
        $event = new MvcEvent();

        $routeMatch = $this->getMockBuilder(RouteMatch::class)
            ->disableOriginalConstructor()
            ->getMock();
        $event->setRouteMatch($routeMatch);

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

        return $event;
    }

    /**
     * @dataProvider backgroundJobProvider
     */
    public function testBackgroundJob($transactions, $executed)
    {
        if ($executed) {
            $this->client
                ->expects($this->once())
                ->method('backgroundJob');
        } else {
            $this->client
                ->expects($this->never())
                ->method('backgroundJob');
        }

        $event = $this->getEvent();

        $this->getListener($transactions)->onRequest($event);
    }

    public function backgroundJobProvider()
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

    public function testShouldSetBackgroundJobWhenConsoleRequest()
    {
        $this->client
            ->expects($this->once())
            ->method('backgroundJob');

        $event = $this->getEvent();
        $event->setRequest(new ConsoleRequest());

        $this->getListener()->onRequest($event);
    }

    public function testShouldNotSetBackgroundJobWhenHttpRequest()
    {
        $this->client
            ->expects($this->never())
            ->method('backgroundJob');

        $event = $this->getEvent();
        $event->setRequest(new HttpRequest());

        $this->getListener()->onRequest($event);
    }
}
