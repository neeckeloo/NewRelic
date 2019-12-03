<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use NewRelic\Client;
use NewRelic\ModuleOptions;
use Psr\Container\ContainerInterface;
use NewRelic\Listener\IgnoreApdexListener;
use NewRelic\TransactionMatcher;

class IgnoreApdexListenerFactory
{
    public function __invoke(ContainerInterface $container): IgnoreApdexListener
    {
        $client = $container->get(Client::class);
        $options = $container->get(ModuleOptions::class);
        $transactionMatcher = new TransactionMatcher($options->getIgnoredApdex());

        return new IgnoreApdexListener($client, $options, $transactionMatcher);
    }
}
