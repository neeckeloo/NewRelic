<?php
namespace NewRelicTest\Listener;

use Laminas\Mvc\MvcEvent;
use NewRelic\ClientInterface;
use NewRelic\Listener\RequestListener;
use NewRelic\ModuleOptions;
use NewRelic\TransactionNameProvider\TransactionNameProviderInterface;
use PHPUnit\Framework\TestCase;

class RequestListenerTest extends TestCase
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var TransactionNameProviderInterface
     */
    protected $transactionNameProvider;

    /**
     * @var RequestListener
     */
    protected $listener;

    /**
     * @var MvcEvent
     */
    protected $event;

    public function setUp(): void
    {
        $this->client = $this->createMock(ClientInterface::class);
        $this->moduleOptions = new ModuleOptions();
        $this->transactionNameProvider = $this->createMock(TransactionNameProviderInterface::class);
        $this->listener = new RequestListener(
            $this->client,
            $this->moduleOptions,
            $this->transactionNameProvider
        );

        $this->event = new MvcEvent();
    }

    public function testOnRequestWhenATransactionNameIsNotProvidedShouldNotCallNameTransactionMethod()
    {
        $transactionName = null;

        $this->transactionNameProvider
            ->expects($this->once())
            ->method('getTransactionName')
            ->will($this->returnValue($transactionName));

        $this->client
            ->expects($this->never())
            ->method('nameTransaction');

        $this->listener->onRequest($this->event);
    }

    public function testOnRequestWhenATransactionNameIsProvidedShouldCallNameTransactionMethod()
    {
        $transactionName = 'foo';

        $this->transactionNameProvider
            ->expects($this->once())
            ->method('getTransactionName')
            ->will($this->returnValue($transactionName));

        $this->client
            ->expects($this->once())
            ->method('nameTransaction')
            ->with($transactionName);

        $this->listener->onRequest($this->event);
    }

    public function testOnRequestWhenApplicationIsProvidedShouldSetAppName()
    {
        $applicationName = 'foo';
        $this->moduleOptions->setApplicationName($applicationName);

        $this->client
            ->expects($this->once())
            ->method('setAppName')
            ->with($applicationName, $this->anything());

        $this->listener->onRequest($this->event);
    }

    public function testOnRequestWhenApplicationIsNotProvidedShouldNotSetAppName()
    {
        $applicationName = '';
        $this->moduleOptions->setApplicationName($applicationName);

        $this->client
            ->expects($this->never())
            ->method('setAppName');

        $this->listener->onRequest($this->event);
    }
}
