<?php
namespace NewRelic\Service;

use NewRelic\Client;
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
        $moduleOptions = $serviceLocator->get('NewRelic\ModuleOptions');

        return new Client($moduleOptions);
    }
}