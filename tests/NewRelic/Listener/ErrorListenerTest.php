<?php
namespace NewRelic\Listener;

use Zend\EventManager\EventManager;
use Zend\Mvc\MvcEvent;

class ErrorListenerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->configuration = new \NewRelic\Configuration();

        $client = $this->getMock('NewRelic\Client', array(), array(), '', false);
        $client
            ->expects($this->any())
            ->method('getConfiguration')
            ->will($this->returnValue($this->configuration));

        $this->listener = new ErrorListener($client);
        $this->event    = new MvcEvent();
    }

    public function testListenerAttached()
    {
        $events = new EventManager();
        $events->attach($this->listener);

        $listeners = $events->getListeners(MvcEvent::EVENT_DISPATCH_ERROR);
        $this->assertEquals(1, count($listeners));
        $listeners = $events->getListeners(MvcEvent::EVENT_RENDER_ERROR);
        $this->assertEquals(1, count($listeners));

        $events->detach($this->listener);

        $listeners = $events->getListeners(MvcEvent::EVENT_DISPATCH_ERROR);
        $this->assertEquals(0, count($listeners));
        $listeners = $events->getListeners(MvcEvent::EVENT_RENDER_ERROR);
        $this->assertEquals(0, count($listeners));
    }

    public function testEventHandlerCallsLogger()
    {
        $mock = new \Zend\Log\Writer\Mock();
        $writers = new \Zend\Stdlib\SplPriorityQueue();
        $writers->insert($mock, 1);

        $queryLog = new \Zend\Log\Logger();
        $queryLog->setWriters($writers);

        $services = new \Zend\ServiceManager\ServiceManager();
        $services->setService('NewRelic\ExceptionLogger', $queryLog);

        $exception = new \Exception("a message");
        $result = (object) array('exception' => $exception);

        $app = $this->getMock('\Zend\Mvc\ApplicationInterface');
        $app
            ->expects($this->any())
            ->method('getServiceManager')
            ->will($this->returnValue($services));

        $this->event->setApplication($app);
        $this->event->setResult($result);

        $this->listener->onError($this->event);

        $this->assertContains($exception->getFile(), $mock->events[0]['message']);
        $this->assertContains((string) $exception->getLine(), $mock->events[0]['message']);
        $this->assertContains($exception->getMessage(), $mock->events[0]['message']);
        $this->assertSame($exception, $mock->events[0]['extra']['exception']);
    }
}
