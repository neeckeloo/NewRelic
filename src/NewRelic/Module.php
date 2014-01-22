<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use NewRelic\Listener\ErrorListener;
use NewRelic\Listener\RequestListener;
use NewRelic\Listener\ResponseListener;

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

    /**
     * @param  MvcEvent $e
     * @return void
     */
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

        $ignoredTransactionListener = $serviceManager->get('NewRelic\IgnoredTransactionListener');
        $eventManager->attach($ignoredTransactionListener);

        $backgroundJobListener = $serviceManager->get('NewRelic\BackgroundJobListener');
        $eventManager->attach($backgroundJobListener);

        $requestListener = new RequestListener($client);
        $eventManager->attach($requestListener);

        $responseListener = new ResponseListener($client);
        $eventManager->attach($responseListener);

        $configuration = $client->getConfiguration();
        if ($configuration->getExceptionsLoggingEnabled()) {
            $errorListener = $serviceManager->get('NewRelic\ErrorListener');
            $eventManager->attach($errorListener);
        }
    }
}
