<?php
namespace NewRelic;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    public function getConfig()
    {
        return require_once(__DIR__ . '/../config/module.config.php');
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

    public function getServiceConfig()
    {
        return array(
            'initializers' => array(
                'client' => function($service, $sm) {
                    if ($service instanceof ClientAwareInterface) {
                        $client = $sm->get('NewRelic\Client');
                        $service->setClient($client);
                    }
                },
                'module_options' => function($service, $sm) {
                    if ($service instanceof ModuleOptionsAwareInterface) {
                        $moduleOptions = $sm->get('NewRelic\ModuleOptions');
                        $service->setModuleOptions($moduleOptions);
                    }
                },
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

        $moduleOptions = $serviceManager->get('NewRelic\ModuleOptions');
        foreach ($moduleOptions->getListeners() as $service) {
            $listener = $serviceManager->get($service);
            $eventManager->attach($listener);
        }
    }
}
