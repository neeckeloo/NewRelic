<?php

declare(strict_types=1);

namespace NewRelic;

use Zend\Mvc\MvcEvent;

interface TransactionMatcherInterface
{
    public function isMatched(MvcEvent $mvcEvent): bool;
}
