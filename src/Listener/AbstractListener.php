<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

abstract class AbstractListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @param ClientInterface $client
     * @param ModuleOptionsInterface $options
     */
    public function __construct(
        ClientInterface $client,
        ModuleOptionsInterface $options
    ) {
        $this->client  = $client;
        $this->options = $options;
    }
}
