<?php
namespace NewRelic\TransactionNameProvider;

use Zend\Mvc\MvcEvent;

interface TransactionNameProviderInterface
{
    public function getTransactionName(MvcEvent $event): ?string;
}
