<?php

declare(strict_types=1);

namespace NewRelic\TransactionNameProvider;

use Laminas\Mvc\MvcEvent;

interface TransactionNameProviderInterface
{
    public function getTransactionName(MvcEvent $event): ?string;
}
