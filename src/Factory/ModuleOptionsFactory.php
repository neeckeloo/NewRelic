<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use Psr\Container\ContainerInterface;
use NewRelic\Exception\RuntimeException;
use NewRelic\ModuleOptions;

class ModuleOptionsFactory
{
    public function __invoke(ContainerInterface $container): ModuleOptions
    {
        $config = $container->get('Config');

        if (! isset($config['newrelic'])) {
            throw new RuntimeException(
                'NewRelic configuration must be defined. Did you copy the config file?'
            );
        }

        return new ModuleOptions($config['newrelic']);
    }
}
