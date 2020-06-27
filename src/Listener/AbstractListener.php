<?php

declare(strict_types=1);

namespace NewRelic\Listener;

use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;

abstract class AbstractListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    protected $client;

    protected $options;

    public function __construct(ClientInterface $client, ModuleOptionsInterface $options)
    {
        $this->client  = $client;
        $this->options = $options;
    }
}
