<?php
namespace NewRelic\Factory;

use NewRelic\Listener\IgnoreTransactionListener;
use NewRelic\TransactionMatcher;

class IgnoreTransactionListenerFactory
{
    public function __invoke($serviceLocator)
    {
        $client  = $serviceLocator->get('NewRelic\Client');
        $options = $serviceLocator->get('NewRelic\ModuleOptions');
        $transactionMatcher = new TransactionMatcher($options->getIgnoredTransactions());

        return new IgnoreTransactionListener($client, $options, $transactionMatcher);
    }
}
