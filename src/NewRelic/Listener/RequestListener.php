<?php
namespace NewRelic\Listener;

use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class RequestListener extends AbstractListener
{
    /**
     * @param Events $events
     * @return void
     */
    public function attach(Events $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRequest'), -100);
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
        if ($matches instanceof RouteMatch) {
            $route = $matches->getMatchedRouteName();
            $this->client->nameTransaction($route);
        }
    }
}
