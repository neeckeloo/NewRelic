<?php
namespace NewRelic\Service;

use NewRelic\Listener\IgnoredTransactionListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic ignored transaction listener factory
 */
class IgnoredTransactionListenerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return IgnoredTransactionListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $client = $serviceLocator->get('NewRelic\Client');
        $moduleOptions = $serviceLocator->get('NewRelic\ModuleOptions');

        return new IgnoredTransactionListener($moduleOptions, $client);
    }
}