<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use Psr\Container\ContainerInterface;
use NewRelic\Listener\RequestListener;

class RequestListenerFactory
{
    public function __invoke(ContainerInterface $container): RequestListener
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');

        $transactionNameProvider = $container->get(
            $options->getTransactionNameProvider()
        );

        return new RequestListener($client, $options, $transactionNameProvider);
    }
}
