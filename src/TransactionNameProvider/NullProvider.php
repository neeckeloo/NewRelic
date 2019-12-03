<?php

declare(strict_types=1);

namespace NewRelic\TransactionNameProvider;

use Zend\Mvc\MvcEvent;

class NullProvider implements TransactionNameProviderInterface
{
    public function getTransactionName(MvcEvent $event): ?string
    {
        return null;
    }
}
