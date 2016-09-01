<?php
namespace NewRelic\Listener;

use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;
use Zend\Mvc\Router\RouteMatch as RouteMatchV2;

class RequestListener extends AbstractListener
{
    /**
     * @param  Events $events
     * @param  int    $priority
     * @return void
     */
    public function attach(Events $events, $priority = -100)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'onRequest'], $priority);
    }

    /**
     * @param  MvcEvent $e
     * @return void
     */
    public function onRequest(MvcEvent $e)
    {
        $appName = $this->options->getApplicationName();
        if ($appName) {
            $this->client->setAppName($appName, $this->options->getLicense());
        }

        $matches = $e->getRouteMatch();
        if ($matches instanceof RouteMatch || $matches instanceof RouteMatchV2) {
            $route = $matches->getMatchedRouteName();
            $this->client->nameTransaction($route);
        }
    }
}
