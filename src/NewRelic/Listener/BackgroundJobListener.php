<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class BackgroundJobListener extends AbstractTransactionListener
{
    /**
     * @param ModuleOptionsInterface $options
     * @param ClientInterface $client
     */
    public function __construct(ModuleOptionsInterface $options, ClientInterface $client)
    {
        parent::__construct($options, $client);
        $this->transactions = $options->getBackgroundJobs();
    }

    /**
     * @param  Events $events
     * @return void
     */
    public function attach(Events $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRequest'), -100);
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

        $this->client->backgroundJob();
    }
}
