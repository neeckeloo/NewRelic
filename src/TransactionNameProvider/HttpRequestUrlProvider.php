<?php
namespace NewRelic\TransactionNameProvider;

use Zend\Http\Request;
use Zend\Mvc\MvcEvent;

class HttpRequestUrlProvider implements TransactionNameProviderInterface
{
    /**
     * {@inheritedDoc}
     */
    public function getTransactionName(MvcEvent $event)
    {
        $request = $event->getRequest();
        if (!$request instanceof Request) {
            return null;
        }

        return $request->getUriString();
    }
}
