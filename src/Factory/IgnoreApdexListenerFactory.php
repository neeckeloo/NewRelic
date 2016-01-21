<?php
namespace NewRelic\Factory;

use NewRelic\Listener\IgnoreApdexListener;
use NewRelic\TransactionMatcher;

class IgnoreApdexListenerFactory
{
    public function __invoke($serviceLocator)
    {
        $client  = $serviceLocator->get('NewRelic\Client');
        $options = $serviceLocator->get('NewRelic\ModuleOptions');
        $transactionMatcher = new TransactionMatcher($options->getIgnoredApdex());

        return new IgnoreApdexListener($client, $options, $transactionMatcher);
    }
}
