<?php
namespace NewRelic\Listener;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

abstract class AbstractTransactionListener extends AbstractListener
{
    /**
     * @var array 
     */
    protected $transactions;

    /**
     * @param  MvcEvent $e
     * @return bool
     */
    protected function isMatchedRequest(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        if (
            $routeMatch instanceof RouteMatch
            && isset($this->transactions['routes'])
            && is_array($this->transactions['routes'])
        ) {
            $matchedRouteName = $routeMatch->getMatchedRouteName();

            if (in_array('*', $this->transactions['routes'])) {
                return true;
            }
            
            foreach ($this->transactions['routes'] as $route) {
                if (fnmatch($route, $matchedRouteName, FNM_CASEFOLD)) {
                    return true;
                }
            }
        }

        $serviceManager = $e->getApplication()->getServiceManager();
        $request = $serviceManager->get('request');

        $controllerName = $request->getControllerName();
        $actionName = $request->getActionName();

        if (
            isset($this->transactions['controllers'])
            && is_array($this->transactions['controllers'])
        ) {
            foreach ($this->transactions['controllers'] as $controller) {
                if (is_string($controller) && $controller == $controllerName) {
                    return true;
                }
                
                if (!is_array($controller) || empty($controller)) {
                    continue;
                }

                if ($controller[0] != $controllerName) {
                    continue;
                }

                if (
                    isset($controller[1])
                    && (!is_array($controller[1]) || !in_array($actionName, $controller[1]))
                ) {
                    continue;
                }

                return true;
            }
        }
    }
}