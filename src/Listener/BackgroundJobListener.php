<?php

declare(strict_types=1);

namespace NewRelic\Listener;

use Laminas\Console\Request as ConsoleRequest;
use Laminas\EventManager\EventManagerInterface as Events;
use Laminas\Mvc\MvcEvent;

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
