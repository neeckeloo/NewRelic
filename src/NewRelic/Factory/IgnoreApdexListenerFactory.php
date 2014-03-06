<?php
namespace NewRelic\Factory;

use NewRelic\Listener\IgnoreApdexListener;
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
        $moduleOptions = $serviceLocator->get('NewRelic\ModuleOptions');

        return new IgnoreApdexListener($moduleOptions->getIgnoredApdex());
    }
}