<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;

interface TransactionMatcherInterface
{
    public function isMatched(MvcEvent $mvcEvent): bool;
}
