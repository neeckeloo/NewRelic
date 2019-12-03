<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use NewRelic\Client;
use NewRelic\ModuleOptions;
use Psr\Container\ContainerInterface;
use NewRelic\Listener\BackgroundJobListener;
use NewRelic\TransactionMatcher;

class BackgroundJobListenerFactory
{
    public function __invoke(ContainerInterface $container): BackgroundJobListener
    {
        $client = $container->get(Client::class);
        $options = $container->get(ModuleOptions::class);
        $transactionMatcher = new TransactionMatcher($options->getBackgroundJobs());

        return new BackgroundJobListener($client, $options, $transactionMatcher);
    }
}
