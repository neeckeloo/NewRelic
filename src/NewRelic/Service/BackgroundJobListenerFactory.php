<?php
namespace NewRelic\Service;

use NewRelic\Listener\BackgroundJobListener;
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
        $moduleOptions = $serviceLocator->get('NewRelic\ModuleOptions');

        return new BackgroundJobListener($moduleOptions->getBackgroundJobs());
    }
}