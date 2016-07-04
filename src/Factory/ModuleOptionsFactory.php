<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Exception\RuntimeException;
use NewRelic\ModuleOptions;

class ModuleOptionsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('Config');

        if (!isset($config['newrelic'])) {
            throw new RuntimeException(
                'NewRelic configuration must be defined. Did you copy the config file?'
            );
        }

        return new ModuleOptions($config['newrelic']);
    }
}
