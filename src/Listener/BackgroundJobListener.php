<?php
namespace NewRelic\Listener;

use Zend\Console\Request as ConsoleRequest;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class BackgroundJobListener extends AbstractTransactionListener
{
    /**
     * @param  Events $events
     * @return void
     */
    public function attach(Events $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRequest'], -100);
    }

    /**
     * @param  MvcEvent $e
     * @return void
     */
    public function onRequest(MvcEvent $e)
    {
        $request = $e->getRequest();
        if (!$request instanceof ConsoleRequest && !$this->isMatchedRequest($e)) {
            return;
        }

        $this->client->backgroundJob();
    }
}
