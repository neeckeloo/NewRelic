<?php
namespace NewRelic\Listener;

use Zend\Console\Request as ConsoleRequest;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class BackgroundJobListener extends AbstractTransactionListener
{
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
        $request = $e->getRequest();
        if (!$request instanceof ConsoleRequest && !$this->isMatchedRequest($e)) {
            return;
        }

        $this->client->backgroundJob();
    }
}
