<?php

declare(strict_types=1);

namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use NewRelic\TransactionNameProvider\TransactionNameProviderInterface;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class RequestListener extends AbstractListener
{
    /**
     * @var TransactionNameProviderInterface
     */
    private $transactionNameProvider;

    public function __construct(
        ClientInterface $client,
        ModuleOptionsInterface $options,
        TransactionNameProviderInterface $transactionNameProvider
    ) {
        parent::__construct($client, $options);

        $this->transactionNameProvider = $transactionNameProvider;
    }

    /**
     * @param  Events $events
     * @param  int    $priority
     * @return void
     */
    public function attach(Events $events, $priority = -100): void
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRequest'], $priority);
    }

    public function onRequest(MvcEvent $e): void
    {
        $appName = $this->options->getApplicationName();
        if ($appName) {
            $this->client->setAppName($appName, $this->options->getLicense());
        }

        $transactionName = $this->transactionNameProvider->getTransactionName($e);
        if ($transactionName) {
            $this->client->nameTransaction($transactionName);
        }
    }
}
