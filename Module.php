<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use NewRelic\Listener\InitBrowserTimingListener;

class Module implements
    ConfigProviderInterface,
    AutoloaderProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        $client = $serviceManager->get('NewRelicClient');
        if (!$client->extensionLoaded()) {
            return;
        }

        /* @var $eventManager \Zend\EventManager\EventManager */
        $eventManager = $application->getEventManager();

        $eventManager->attach(MvcEvent::EVENT_ROUTE, function(MvcEvent $e) use ($client) {
            $matches = $e->getRouteMatch();
            $route   = $matches->getMatchedRouteName();

            $client->nameTransaction($route);
        });

        $eventManager->attach(MvcEvent::EVENT_FINISH, function(MvcEvent $e) use ($client) {
            $configuration = $client->getConfiguration();

            $client->setAppName(
                $configuration->getApplicationName(),
                $configuration->getLicense()
            );
        }, 100);

        $initBrowserTimingListener = new InitBrowserTimingListener($client);
        $eventManager->attach(MvcEvent::EVENT_FINISH, array($initBrowserTimingListener, 'initBrowserTiming'));

        $configuration = $client->getConfiguration();
        if ($configuration->getExceptionsLoggingEnabled()) {
            $sharedManager = $eventManager->getSharedManager();
            $sharedManager->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, function($e) use ($serviceManager) {
                if ($e->getParam('exception')) {
                    $serviceManager->get('Zend\Log\Logger')->err($e->getParam('exception'));
                }
            });
        }
    }
}