<?php
namespace NewRelic;

use Zend\Router\RouteMatch;

class TransactionMatcher implements TransactionMatcherInterface
{
    /**
     * @var array
     */
    private $transactions;

    /**
     * @param array $transactions
     */
    public function __construct(array $transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @param  RouteMatch $routeMatch
     * @return bool
     */
    public function isMatched(RouteMatch $routeMatch)
    {
        $matchedRouteName = $routeMatch->getMatchedRouteName();
        if ($this->isRouteMatched($matchedRouteName)) {
            return true;
        }

        $controllerName = $routeMatch->getParam('controller', 'index');
        $actionName     = $routeMatch->getParam('action', 'index');

        return $this->isControllerMatched($controllerName, $actionName);
    }

    /**
     * @param  string $routeName
     * @return bool
     */
    private function isRouteMatched($routeName)
    {
        if (
            isset($this->transactions['routes'])
            && is_array($this->transactions['routes'])
        ) {
            if (in_array('*', $this->transactions['routes'])) {
                return true;
            }

            foreach ($this->transactions['routes'] as $route) {
                if (fnmatch($route, $routeName, FNM_CASEFOLD)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param  string $controllerName
     * @param  string $actionName
     * @return bool
     */
    private function isControllerMatched($controllerName, $actionName)
    {
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

        return false;
    }
}
