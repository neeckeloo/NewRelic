<?php
namespace NewRelicTest\Listener;

use Exception;
use NewRelic\ClientInterface;
use NewRelic\Listener\ErrorListener;
use NewRelic\ModuleOptions;
use Psr\Log\LoggerInterface;
use Zend\EventManager\EventManager;
use Zend\Mvc\MvcEvent;

class ErrorListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testAttachShouldAttachEventListeners()
    {
        $client = $this->getMock(ClientInterface::class);
        $options = $this->getMock(ModuleOptions::class);
        $psrLogger = $this->getMock(LoggerInterface::class);
        $listener = new ErrorListener($client, $options, $psrLogger);
        $events = new EventManager();

        $listener->attach($events);

        $listeners = $events->getListeners(MvcEvent::EVENT_DISPATCH_ERROR);
        $this->assertCount(1, $listeners);
        $listeners = $events->getListeners(MvcEvent::EVENT_RENDER_ERROR);
        $this->assertCount(1, $listeners);
    }

    public function testDetachShouldDetachEventListeners()
    {
        $client = $this->getMock(ClientInterface::class);
        $options = $this->getMock(ModuleOptions::class);
        $psrLogger = $this->getMock(LoggerInterface::class);
        $listener = new ErrorListener($client, $options, $psrLogger);
        $events = new EventManager();
        $listener->attach($events);

        $listener->detach($events);

        $this->assertEmpty($events->getListeners(MvcEvent::EVENT_DISPATCH_ERROR));
        $this->assertEmpty($events->getListeners(MvcEvent::EVENT_RENDER_ERROR));
    }

    public function testOnErrorWhenExceptionLoggingIsEnabledShouldLogException()
    {
        $client = $this->getMock(ClientInterface::class);
        $options = new ModuleOptions([
            'exceptions_logging_enabled' => true,
        ]);
        $psrLogger = $this->getMock(LoggerInterface::class);
        $listener = new ErrorListener($client, $options, $psrLogger);

        $mvcEvent = $this->createMvcEventWithException();

        $psrLogger
            ->expects($this->once())
            ->method('error')
            ->with(
                $this->isType('string'),
                ['exception' => $mvcEvent->getParam('exception')]
            );

        $listener->onError($mvcEvent);
    }

    public function testOnErrorWhenExceptionLoggingIsDisabledShouldNotLogException()
    {
        $client = $this->getMock(ClientInterface::class);
        $options = new ModuleOptions([
            'exceptions_logging_enabled' => false,
        ]);
        $psrLogger = $this->getMock(LoggerInterface::class);
        $listener = new ErrorListener($client, $options, $psrLogger);

        $psrLogger
            ->expects($this->never())
            ->method('error');

        $listener->onError($this->createMvcEventWithException());
    }

    private function createMvcEventWithException()
    {
        $mvcEvent = new MvcEvent();
        $exception = new Exception('foo');
        $mvcEvent->setParam('exception', $exception);

        return $mvcEvent;
    }
}
