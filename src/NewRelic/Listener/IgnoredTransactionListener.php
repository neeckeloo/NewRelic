<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class IgnoredTransactionListener extends AbstractTransactionListener
{
    /**
     * @param ModuleOptionsInterface $options
     * @param ClientInterface $client
     */
    public function __construct(ModuleOptionsInterface $options, ClientInterface $client)
    {
        parent::__construct($options, $client);
        $this->transactions = $options->getIgnoredTransactions();
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
