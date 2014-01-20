<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use NewRelic\Listener\RequestListener;
use NewRelic\Listener\ResponseListener;
use NewRelic\Listener\ErrorListener;

class Module implements
    ConfigProviderInterface,
    AutoloaderProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
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

        $client = $serviceManager->get('NewRelic\Client');
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
            $logger = $serviceManager->get('NewRelic\ExceptionLogger');
            $errorListener = new ErrorListener($client, $logger);
            $eventManager->attach($errorListener);
        }
    }
}
