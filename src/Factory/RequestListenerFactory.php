<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use NewRelic\Client;
use NewRelic\ModuleOptions;
use Psr\Container\ContainerInterface;
use NewRelic\Listener\RequestListener;

class RequestListenerFactory
{
    public function __invoke(ContainerInterface $container): RequestListener
    {
        $client = $container->get(Client::class);
        $options = $container->get(ModuleOptions::class);

        $transactionNameProvider = $container->get(
            $options->getTransactionNameProvider()
        );

        return new RequestListener($client, $options, $transactionNameProvider);
    }
}
