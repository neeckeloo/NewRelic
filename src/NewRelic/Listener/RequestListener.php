<?php
namespace NewRelic\Listener;

use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class RequestListener extends AbstractListener
{
    /**
     * @param Events $events
     * @return void
     */
    public function attach(Events $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, array($this, 'onRequest'), 100);
    }

    /**
     * @param MvcEvent $e
     * @return void
     */
    public function onRequest(MvcEvent $e)
    {
        $configuration = $this->client->getConfiguration();

        $this->client->setAppName(
            $configuration->getApplicationName(),
            $configuration->getLicense()
        );

        $matches = $e->getRouteMatch();
        $route   = $matches->getMatchedRouteName();

        $this->client->nameTransaction($route);
    }
}