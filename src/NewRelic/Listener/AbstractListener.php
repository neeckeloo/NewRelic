<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\EventManager\ListenerAggregateInterface;

abstract class AbstractListener implements ListenerAggregateInterface
{
    /**
     * @var ModuleOptionsInterface
     */
    protected $options;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @param ModuleOptionsInterface $options
     * @param ClientInterface $client
     */
    public function __construct(ModuleOptionsInterface $options, ClientInterface $client)
    {
        $this->options = $options;
        $this->client = $client;
    }

    /**
     * @param Events $events
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