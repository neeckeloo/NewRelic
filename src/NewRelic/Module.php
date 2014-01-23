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

        $moduleOptions = $serviceManager->get('NewRelic\ModuleOptions');

        $requestListener = new RequestListener($moduleOptions, $client);
        $eventManager->attach($requestListener);

        $responseListener = new ResponseListener($moduleOptions, $client);
        $eventManager->attach($responseListener);

        if ($moduleOptions->getExceptionsLoggingEnabled()) {
            $errorListener = $serviceManager->get('NewRelic\ErrorListener');
            $eventManager->attach($errorListener);
        }
    }
}
