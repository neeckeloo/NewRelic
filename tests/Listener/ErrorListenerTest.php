<?php
namespace NewRelicTest\Listener;

use Exception;
use NewRelic\Listener\ErrorListener;
use NewRelic\ModuleOptions;
use Psr\Log\LoggerInterface;
use Zend\EventManager\EventManager;
use Zend\Mvc\MvcEvent;

class ErrorListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testAttachShouldAttachEventListeners()
    {
        $psrLogger = $this->getMock(LoggerInterface::class);
        $listener = new ErrorListener($psrLogger);
        $events = new EventManager();

        $listener->attach($events);

        $listeners = $events->getListeners(MvcEvent::EVENT_DISPATCH_ERROR);
        $this->assertCount(1, $listeners);
        $listeners = $events->getListeners(MvcEvent::EVENT_RENDER_ERROR);
        $this->assertCount(1, $listeners);
    }

    public function testDetachShouldDetachEventListeners()
    {
        $psrLogger = $this->getMock(LoggerInterface::class);
        $listener = new ErrorListener($psrLogger);
        $events = new EventManager();
        $listener->attach($events);

        $listener->detach($events);

        $this->assertEmpty($events->getListeners(MvcEvent::EVENT_DISPATCH_ERROR));
        $this->assertEmpty($events->getListeners(MvcEvent::EVENT_RENDER_ERROR));
    }

    public function testOnErrorWhenExceptionLoggingIsEnabledShouldLogException()
    {
        $psrLogger = $this->getMock(LoggerInterface::class);
        $listener = new ErrorListener($psrLogger);

        $moduleOptions = new ModuleOptions([
            'exceptions_logging_enabled' => true,
        ]);
        $listener->setModuleOptions($moduleOptions);

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
        $psrLogger = $this->getMock(LoggerInterface::class);
        $listener = new ErrorListener($psrLogger);

        $moduleOptions = new ModuleOptions([
            'exceptions_logging_enabled' => false,
        ]);
        $listener->setModuleOptions($moduleOptions);

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
