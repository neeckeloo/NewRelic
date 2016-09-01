<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;

interface TransactionMatcherInterface
{
    /**
     * @param  MvcEvent $mvcEvent
     * @return bool
     */
    public function isMatched(MvcEvent $mvcEvent);
}
