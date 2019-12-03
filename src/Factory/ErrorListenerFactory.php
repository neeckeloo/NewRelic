<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use NewRelic\Client;
use NewRelic\ModuleOptions;
use Psr\Container\ContainerInterface;
use NewRelic\Listener\ErrorListener;

class ErrorListenerFactory
{
    public function __invoke(ContainerInterface $container): ErrorListener
    {
        $client = $container->get(Client::class);
        $options = $container->get(ModuleOptions::class);
        $logger = $container->get('NewRelic\Logger');

        return new ErrorListener($client, $options, $logger);
    }
}
