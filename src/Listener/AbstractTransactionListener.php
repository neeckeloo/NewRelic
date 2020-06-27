<?php

declare(strict_types=1);

namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use NewRelic\TransactionMatcher;
use Laminas\Mvc\MvcEvent;

abstract class AbstractTransactionListener extends AbstractListener
{
    /**
     * @var TransactionMatcher
     */
    protected $transactionMatcher;

    public function __construct(
        ClientInterface $client,
        ModuleOptionsInterface $options,
        TransactionMatcher $transactionMatcher
    ) {
        parent::__construct($client, $options);
        $this->transactionMatcher = $transactionMatcher;
    }

    protected function isMatchedRequest(MvcEvent $e): bool
    {
        return $this->transactionMatcher->isMatched($e);
    }
}
