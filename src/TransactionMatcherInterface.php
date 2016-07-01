<?php
namespace NewRelic;

use Zend\Router\RouteMatch;

interface TransactionMatcherInterface
{
    /**
     * @param  RouteMatch $routeMatch
     * @return bool
     */
    public function isMatched(RouteMatch $routeMatch);
}
