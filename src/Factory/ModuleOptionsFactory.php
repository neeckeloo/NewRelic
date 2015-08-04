<?php
namespace NewRelic\Factory;

use NewRelic\Exception\RuntimeException;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic module options factory
 */
class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        if (!isset($config['newrelic'])) {
            throw new RuntimeException(
                'NewRelic configuration must be defined. Did you copy the config file?'
            );
        }

        return new ModuleOptions($config['newrelic']);
    }
}
