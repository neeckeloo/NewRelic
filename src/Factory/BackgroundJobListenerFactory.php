<?php
namespace NewRelic\Factory;

use NewRelic\Listener\BackgroundJobListener;
use NewRelic\TransactionMatcher;

class BackgroundJobListenerFactory
{
    public function __invoke($serviceLocator)
    {
        $client  = $serviceLocator->get('NewRelic\Client');
        $options = $serviceLocator->get('NewRelic\ModuleOptions');
        $transactionMatcher = new TransactionMatcher($options->getBackgroundJobs());

        return new BackgroundJobListener($client, $options, $transactionMatcher);
    }
}
