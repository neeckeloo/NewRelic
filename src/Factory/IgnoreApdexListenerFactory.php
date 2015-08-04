<?php
namespace NewRelic\Factory;

use NewRelic\Listener\IgnoreApdexListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic ignore apdex listener factory
 */
class IgnoreApdexListenerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return IgnoreApdexListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);

        return new IgnoreApdexListener($moduleOptions->getIgnoredApdex());
    }
}