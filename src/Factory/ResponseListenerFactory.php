<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use NewRelic\Client;
use NewRelic\ModuleOptions;
use Psr\Container\ContainerInterface;
use NewRelic\Listener\ResponseListener;

class ResponseListenerFactory
{
    public function __invoke(ContainerInterface $container): ResponseListener
    {
        $client = $container->get(Client::class);
        $options = $container->get(ModuleOptions::class);

        return new ResponseListener($client, $options);
    }
}
