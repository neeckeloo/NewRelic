<?php
namespace NewRelic\Service;

use NewRelic\Client;
use NewRelic\Configuration;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic client factory
 */
class ClientFactory implements FactoryInterface
{
    /**
     * Create the NewRelic client
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Client
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $configuration = new Configuration($config['newrelic']);

        return new Client($configuration);
    }
}