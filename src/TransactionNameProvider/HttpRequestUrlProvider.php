<?php

declare(strict_types=1);

namespace NewRelic\TransactionNameProvider;

use Zend\Http\Request;
use Zend\Mvc\MvcEvent;

class HttpRequestUrlProvider implements TransactionNameProviderInterface
{
    public function getTransactionName(MvcEvent $event): ?string
    {
        $request = $event->getRequest();
        if (!$request instanceof Request) {
            return null;
        }

        return $request->getUriString();
    }
}
