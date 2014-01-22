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
        $configuration = $serviceLocator->get('NewRelic\Configuration');

        return new IgnoredTransactionListener($client, $configuration->getIgnoredTransactions());
    }
}