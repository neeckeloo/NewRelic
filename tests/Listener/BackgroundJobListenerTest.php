<?php
namespace NewRelicTest\Listener;

use Laminas\Console\Request as ConsoleRequest;
use Laminas\Http\Request as HttpRequest;
use Laminas\Mvc\MvcEvent;
use Laminas\Router\RouteMatch;
use Laminas\Mvc\Router\RouteMatch as RouteMatchV2;
use NewRelic\Client;
use NewRelic\Listener\BackgroundJobListener;
use NewRelic\ModuleOptionsInterface;
use NewRelic\TransactionMatcher;
use PHPUnit\Framework\TestCase;

class BackgroundJobListenerTest extends TestCase
{
    public function testOnRequestGivenConsoleRequestAndMatchedTransactionShouldSetBackgroundJob()
    {
        $moduleOptions = $this->createMock(ModuleOptionsInterface::class);
        $event = $this->getEvent();
        $event->setRequest(new ConsoleRequest());

        $transactionMatcher = $this->getTransactionMatcherMock();
        $transactionMatcher
            ->method('isMatched')
            ->will($this->returnValue(true));

        $client = $this->getClientMock();
        $client
            ->expects($this->once())
            ->method('backgroundJob');

        $listener = new BackgroundJobListener($client, $moduleOptions, $transactionMatcher);

        $listener->onRequest($event);
    }

    public function testOnRequestGivenHttpRequestAndMatchedTransactionShouldSetBackgroundJob()
    {
        $moduleOptions = $this->createMock(ModuleOptionsInterface::class);
        $event = $this->getEvent();
        $event->setRequest(new HttpRequest());

        $transactionMatcher = $this->getTransactionMatcherMock();
        $transactionMatcher
            ->method('isMatched')
            ->will($this->returnValue(true));

        $client = $this->getClientMock();
        $client
            ->expects($this->once())
            ->method('backgroundJob');

        $listener = new BackgroundJobListener($client, $moduleOptions, $transactionMatcher);

        $listener->onRequest($event);
    }

    public function testOnRequestGivenConsoleRequestAndNotMatchedTransactionShouldSetBackgroundJob()
    {
        $moduleOptions = $this->createMock(ModuleOptionsInterface::class);
        $event = $this->getEvent();
        $event->setRequest(new ConsoleRequest());

        $transactionMatcher = $this->getTransactionMatcherMock();
        $transactionMatcher
            ->method('isMatched')
            ->will($this->returnValue(false));

        $client = $this->getClientMock();
        $client
            ->expects($this->once())
            ->method('backgroundJob');

        $listener = new BackgroundJobListener($client, $moduleOptions, $transactionMatcher);

        $listener->onRequest($event);
    }

    public function testOnRequestGivenHttpRequestAndNotMatchedTransactionShouldNotSetBackgroundJob()
    {
        $moduleOptions = $this->createMock(ModuleOptionsInterface::class);
        $event = $this->getEvent();
        $event->setRequest(new HttpRequest());

        $transactionMatcher = $this->getTransactionMatcherMock();
        $transactionMatcher
            ->method('isMatched')
            ->will($this->returnValue(false));

        $client = $this->getClientMock();
        $client
            ->expects($this->never())
            ->method('backgroundJob');

        $listener = new BackgroundJobListener($client, $moduleOptions, $transactionMatcher);

        $listener->onRequest($event);
    }

    private function getClientMock()
    {
        return $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['backgroundJob'])
            ->getMock();
    }

    private function getTransactionMatcherMock()
    {
        return $this->getMockBuilder(TransactionMatcher::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return MvcEvent
     */
    private function getEvent()
    {
        $event = new MvcEvent();
        $event->setRouteMatch(class_exists(RouteMatch::class) ? new RouteMatch([]) : new RouteMatchV2([]));

        return $event;
    }
}
