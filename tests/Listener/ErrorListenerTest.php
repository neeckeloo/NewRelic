<?php
namespace NewRelicTest\Listener;

use Exception;
use NewRelic\ClientInterface;
use NewRelic\Listener\ErrorListener;
use NewRelic\ModuleOptions;
use Psr\Log\LoggerInterface;
use Zend\Mvc\MvcEvent;

class ErrorListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnErrorWhenExceptionLoggingIsEnabledShouldLogException()
    {
        $client = $this->createMock(ClientInterface::class);
        $options = new ModuleOptions([
            'exceptions_logging_enabled' => true,
        ]);
        $psrLogger = $this->createMock(LoggerInterface::class);
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
        $client = $this->createMock(ClientInterface::class);
        $options = new ModuleOptions([
            'exceptions_logging_enabled' => false,
        ]);
        $psrLogger = $this->createMock(LoggerInterface::class);
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
