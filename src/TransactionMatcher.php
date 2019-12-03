<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;

class TransactionMatcher implements TransactionMatcherInterface
{
    /**
     * @var array
     */
    private $transactions;

    public function __construct(array $transactions)
    {
        $this->transactions = $transactions;
    }

    public function isMatched(MvcEvent $mvcEvent): bool
    {
        $routeMatch = $mvcEvent->getRouteMatch();
        $matchedRouteName = $routeMatch->getMatchedRouteName();
        if ($this->isRouteMatched($matchedRouteName)) {
            return true;
        }

        $controllerName = $routeMatch->getParam('controller', 'index');
        $actionName     = $routeMatch->getParam('action', 'index');

        return $this->isControllerMatched($controllerName, $actionName);
    }

    private function isRouteMatched($routeName): bool
    {
        if (
            isset($this->transactions['routes'])
            && \is_array($this->transactions['routes'])
        ) {
            if (\in_array('*', $this->transactions['routes'])) {
                return true;
            }

            foreach ($this->transactions['routes'] as $route) {
                if (\fnmatch($route, $routeName, FNM_CASEFOLD)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function isControllerMatched(string $controllerName, string $actionName): bool
    {
        if (
            isset($this->transactions['controllers'])
            && \is_array($this->transactions['controllers'])
        ) {
            foreach ($this->transactions['controllers'] as $controller) {
                if (\is_string($controller) && $controller == $controllerName) {
                    return true;
                }

                if (!\is_array($controller) || empty($controller)) {
                    continue;
                }

                if ($controller[0] != $controllerName) {
                    continue;
                }

                if (
                    isset($controller[1])
                    && (!\is_array($controller[1]) || !\in_array($actionName, $controller[1]))
                ) {
                    continue;
                }

                return true;
            }
        }

        return false;
    }
}
