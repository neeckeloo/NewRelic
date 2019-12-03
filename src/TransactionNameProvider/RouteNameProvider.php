<?php
namespace NewRelic\TransactionNameProvider;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch as RouteMatchV2;
use Zend\Router\RouteMatch;

class RouteNameProvider implements TransactionNameProviderInterface
{
    public function getTransactionName(MvcEvent $event): ?string
    {
        $matches = $event->getRouteMatch();

        if (!$matches instanceof RouteMatch && !$matches instanceof RouteMatchV2) {
            return null;
        }

        return $matches->getMatchedRouteName();
    }
}