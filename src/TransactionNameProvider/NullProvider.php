<?php
namespace NewRelic\TransactionNameProvider;

use Zend\Mvc\MvcEvent;

class NullProvider implements TransactionNameProviderInterface
{
    public function getTransactionName(MvcEvent $event): ?string
    {
        return null;
    }
}
