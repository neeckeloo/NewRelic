<?php
namespace NewRelic\TransactionNameProvider;

use Zend\Mvc\MvcEvent;

class NullProvider implements TransactionNameProviderInterface
{
    /**
     * {@inheritedDoc}
     */
    public function getTransactionName(MvcEvent $event)
    {
        return null;
    }
}
