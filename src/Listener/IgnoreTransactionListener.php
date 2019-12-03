<?php

declare(strict_types=1);

namespace NewRelic\Listener;

use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class IgnoreTransactionListener extends AbstractTransactionListener
{
    /**
     * @param  Events $events
     * @param  int    $priority
     * @return void
     */
    public function attach(Events $events, $priority = -99): void
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRequest'], $priority);
    }

    public function onRequest(MvcEvent $e): void
    {
        if (!$this->isMatchedRequest($e)) {
            return;
        }

        $this->client->ignoreTransaction();
    }
}
