<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use Zend\Mvc\MvcEvent;

class IgnoredTransactionListenerTest extends \PHPUnit_Framework_TestCase
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
            ->setMethods(array('ignoreTransaction'))
            ->getMock();
    }

    /**
     * @param  array $transactions
     * @return TransactionListener
     */
    protected function getListener($transactions)
    {
        $moduleOptions = $this->getMockBuilder('NewRelic\ModuleOptions')
            ->setMethods(array('getIgnoredTransactions'))
            ->getMock();

        $moduleOptions
            ->expects($this->once())
            ->method('getIgnoredTransactions')
            ->will($this->returnValue($transactions));

        return new IgnoredTransactionListener($moduleOptions, $this->client);
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

        $application = $this->getMockBuilder('Zend\Mvc\Application')
            ->disableOriginalConstructor()
            ->getMock();
        $event->setApplication($application);

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceLocatorInterface')
            ->getMock();

        $application
            ->expects($this->any())
            ->method('getServiceManager')
            ->will($this->returnValue($serviceManager));

        $request = $this->getMockBuilder('Zend\Http\Request')
            ->setMethods(array('getControllerName', 'getActionName'))
            ->getMock();

        $serviceManager
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValue($request));

        $request
            ->expects($this->any())
            ->method('getControllerName')
            ->will($this->returnValue($this->currentController));

        $request
            ->expects($this->any())
            ->method('getActionName')
            ->will($this->returnValue($this->currentAction));

        return $event;
    }

    /**
     * @dataProvider ignoreTransactionProvider
     */
    public function testIgnoreTransaction($transactions, $executed)
    {
        if ($executed) {
            $this->client
                ->expects($this->once())
                ->method('ignoreTransaction');
        } else {
            $this->client
                ->expects($this->never())
                ->method('ignoreTransaction');
        }
        
        $listener = $this->getListener($transactions);

        $event = $this->getEvent();

        $listener->onRequest($event);
    }

    public function ignoreTransactionProvider()
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
}
