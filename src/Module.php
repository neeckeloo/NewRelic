<?php
namespace NewRelic;

use NewRelic\Client;
use NewRelic\ModuleOptions;
use Zend\Loader\StandardAutoloader;
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
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            StandardAutoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'initializers' => [
                'client' => function($service, $sm) {
                    if ($service instanceof ClientAwareInterface) {
                        $client = $sm->get(Client::class);
                        $service->setClient($client);
                    }
                },
                'module_options' => function($service, $sm) {
                    if ($service instanceof ModuleOptionsAwareInterface) {
                        $moduleOptions = $sm->get(ModuleOptions::class);
                        $service->setModuleOptions($moduleOptions);
                    }
                },
            ],
        ];
    }

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        $client = $serviceManager->get(Client::class);
        if (!$client->extensionLoaded()) {
            return;
        }

        /* @var $eventManager \Zend\EventManager\EventManager */
        $eventManager = $application->getEventManager();

        $moduleOptions = $serviceManager->get(ModuleOptions::class);
        foreach ($moduleOptions->getListeners() as $service) {
            $listener = $serviceManager->get($service);
            $eventManager->attach($listener);
        }
    }
}
