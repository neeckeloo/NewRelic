<?php
namespace NewRelicTest\Listener;

use NewRelic\ClientInterface;
use NewRelic\Listener\BackgroundJobListener;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\MvcEvent;

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
        $this->client = $this->getMockBuilder('NewRelic\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('backgroundJob'))
            ->getMock();
    }

    /**
     * @param  array $transactions
     * @return BackgroundJobListener
     */
    protected function getListener($transactions = array())
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
        
        $routeMatch = $this->getMockBuilder('Zend\Mvc\Router\RouteMatch')
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
        return array(
            // Client method called
            array(
                array('routes' => array('foo/bar')),
                true,
            ),
            array(
                array('routes' => array('foo*')),
                true,
            ),
            array(
                array('routes' => array('*')),
                true,
            ),
            array(
                array('controllers' => array(
                    'FooController'
                )),
                true,
            ),
            array(
                array('controllers' => array(
                    array('FooController', array('foo'))
                )),
                true,
            ),

            // Client method avoided
            array(
                array('routes' => array('bar/foo')),
                false,
            ),
            array(
                array('controllers' => array(
                    'BarController'
                )),
                false,
            ),
            array(
                array('controllers' => array(
                    array('FooController', array('bar'))
                )),
                false,
            ),
        );
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
