<?php
namespace NewRelic;

use Zend\Mvc\Router\RouteMatch;

interface TransactionMatcherInterface
{
    /**
     * @param  RouteMatch $routeMatch
     * @return bool
     */
    public function isMatched(RouteMatch $routeMatch);
}
