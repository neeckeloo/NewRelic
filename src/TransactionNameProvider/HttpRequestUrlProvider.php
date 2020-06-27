<?php

declare(strict_types=1);

namespace NewRelic\TransactionNameProvider;

use Laminas\Http\Request;
use Laminas\Mvc\MvcEvent;

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
