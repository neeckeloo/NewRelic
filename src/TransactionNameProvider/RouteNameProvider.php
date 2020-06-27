<?php

declare(strict_types=1);

namespace NewRelic\TransactionNameProvider;

use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\Router\RouteMatch as RouteMatchV2;
use Laminas\Router\RouteMatch;

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
