<?php
namespace NewRelicTest\Listener;

use NewRelic\Client;
use NewRelic\Listener\IgnoreTransactionListener;
use NewRelic\ModuleOptionsInterface;
use NewRelic\TransactionMatcher;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class IgnoreTransactionListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnRequestGivenMatchedTransactionShouldSetIgnoreTransaction()
    {
        $moduleOptions = $this->getMock(ModuleOptionsInterface::class);

        $transactionMatcher = $this->getTransactionMatcherMock();
        $transactionMatcher
            ->method('isMatched')
            ->will($this->returnValue(true));

        $client = $this->getClientMock();
        $client
            ->expects($this->once())
            ->method('ignoreTransaction');

        $listener = new IgnoreTransactionListener($client, $moduleOptions, $transactionMatcher);

        $listener->onRequest($this->getEvent());
    }

    public function testOnRequestGivenNotMatchedTransactionShouldNotSetIgnoreTransaction()
    {
        $moduleOptions = $this->getMock(ModuleOptionsInterface::class);

        $transactionMatcher = $this->getTransactionMatcherMock();
        $transactionMatcher
            ->method('isMatched')
            ->will($this->returnValue(false));

        $client = $this->getClientMock();
        $client
            ->expects($this->never())
            ->method('ignoreTransaction');

        $listener = new IgnoreTransactionListener($client, $moduleOptions, $transactionMatcher);

        $listener->onRequest($this->getEvent());
    }

    private function getClientMock()
    {
        return $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['ignoreTransaction'])
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
