<?php
namespace NewRelic\Factory;

use Psr\Container\ContainerInterface;
use NewRelic\Listener\IgnoreApdexListener;
use NewRelic\TransactionMatcher;

class IgnoreApdexListenerFactory
{
    public function __invoke(ContainerInterface $container): IgnoreApdexListener
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');
        $transactionMatcher = new TransactionMatcher($options->getIgnoredApdex());

        return new IgnoreApdexListener($client, $options, $transactionMatcher);
    }
}
