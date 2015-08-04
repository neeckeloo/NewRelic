<?php
namespace NewRelic\Factory;

use NewRelic\Listener\IgnoreTransactionListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic ignore transaction listener factory
 */
class IgnoreTransactionListenerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return IgnoreTransactionListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $moduleOptions = $serviceLocator->get(ModuleOptions::class);

        return new IgnoreTransactionListener($moduleOptions->getIgnoredTransactions());
    }
}