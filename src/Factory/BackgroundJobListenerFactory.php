<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use Psr\Container\ContainerInterface;
use NewRelic\Listener\BackgroundJobListener;
use NewRelic\TransactionMatcher;

class BackgroundJobListenerFactory
{
    public function __invoke(ContainerInterface $container): BackgroundJobListener
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');
        $transactionMatcher = new TransactionMatcher($options->getBackgroundJobs());

        return new BackgroundJobListener($client, $options, $transactionMatcher);
    }
}
