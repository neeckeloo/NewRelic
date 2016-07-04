<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Listener\IgnoreTransactionListener;
use NewRelic\TransactionMatcher;

class IgnoreTransactionListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');
        $transactionMatcher = new TransactionMatcher($options->getIgnoredTransactions());

        return new IgnoreTransactionListener($client, $options, $transactionMatcher);
    }
}
