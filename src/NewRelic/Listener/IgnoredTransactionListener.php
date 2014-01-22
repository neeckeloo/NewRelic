<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ConfigurationInterface;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class IgnoredTransactionListener extends AbstractTransactionListener
{
    /**
     * @param ConfigurationInterface $configuration
     * @param ClientInterface $client
     */
    public function __construct(ConfigurationInterface $configuration, ClientInterface $client)
    {
        parent::__construct($configuration, $client);
        $this->transactions = $configuration->getIgnoredTransactions();
    }

    /**
     * @param  Events $events
     * @return void
     */
    public function attach(Events $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRequest'), -99);
    }

    /**
     * @param  MvcEvent $e
     * @return void
     */
    public function onRequest(MvcEvent $e)
    {
        if (!$this->isMatchedRequest($e)) {
            return;
        }

        $this->client->ignoreTransaction();
    }
}
