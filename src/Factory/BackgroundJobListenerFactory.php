<?php
namespace NewRelic\Factory;

use NewRelic\Listener\BackgroundJobListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic background job listener factory
 */
class BackgroundJobListenerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return BackgroundJobListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);

        return new BackgroundJobListener($moduleOptions->getBackgroundJobs());
    }
}