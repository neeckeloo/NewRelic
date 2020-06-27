<?php

declare(strict_types=1);

namespace NewRelic;

use Laminas\Mvc\MvcEvent;

interface TransactionMatcherInterface
{
    public function isMatched(MvcEvent $mvcEvent): bool;
}
