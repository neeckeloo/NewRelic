<?php

declare(strict_types=1);

namespace NewRelic\TransactionNameProvider;

use Zend\Mvc\MvcEvent;

interface TransactionNameProviderInterface
{
    public function getTransactionName(MvcEvent $event): ?string;
}
