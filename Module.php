<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use NewRelic\Listener\RequestListener;
use NewRelic\Listener\ResponseListener;

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

        $requestListener = new RequestListener($client);
        $eventManager->attach($requestListener);

        $responseListener = new ResponseListener($client);
        $eventManager->attach($responseListener);

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