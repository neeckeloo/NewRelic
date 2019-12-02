<?php
namespace NewRelic\Factory;

use Psr\Container\ContainerInterface;
use NewRelic\Listener\IgnoreTransactionListener;
use NewRelic\TransactionMatcher;

class IgnoreTransactionListenerFactory
{
    public function __invoke(ContainerInterface $container): IgnoreTransactionListener
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');
        $transactionMatcher = new TransactionMatcher($options->getIgnoredTransactions());

        return new IgnoreTransactionListener($client, $options, $transactionMatcher);
    }
}
