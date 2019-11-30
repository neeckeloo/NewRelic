<?php
namespace NewRelic;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\Loader\StandardAutoloader;
use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @return mixed[]
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @return mixed[]
     */
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

    /**
     * @param MvcEvent $e
     * @return void
     * @throws \Interop\Container\Exception\ContainerException
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

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $serviceManager->get(ModuleOptions::class);
        foreach ($moduleOptions->getListeners() as $service) {
            /** @var ListenerAggregateInterface $listener */
            $listener = $serviceManager->get($service);
            $listener->attach($eventManager);
        }
    }
}
