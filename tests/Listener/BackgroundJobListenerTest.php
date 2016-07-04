<?php
namespace NewRelicTest\Listener;

use NewRelic\Client;
use NewRelic\Listener\BackgroundJobListener;
use NewRelic\ModuleOptionsInterface;
use NewRelic\TransactionMatcher;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;

class BackgroundJobListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnRequestGivenConsoleRequestAndMatchedTransactionShouldSetBackgroundJob()
    {
        $moduleOptions = $this->getMock(ModuleOptionsInterface::class);
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
        $moduleOptions = $this->getMock(ModuleOptionsInterface::class);
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
        $moduleOptions = $this->getMock(ModuleOptionsInterface::class);
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
        $moduleOptions = $this->getMock(ModuleOptionsInterface::class);
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
        $event->setRouteMatch(new RouteMatch([]));

        return $event;
    }
}
