<?php
namespace NewRelic\Listener;

use NewRelic\Client;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\EventManager\ListenerAggregateInterface;

abstract class AbstractListener implements ListenerAggregateInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @param Client $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Events $events
     * @return void
     */
    public function detach(Events $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}