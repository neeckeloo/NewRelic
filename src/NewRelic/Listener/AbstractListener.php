<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ConfigurationInterface;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\EventManager\ListenerAggregateInterface;

abstract class AbstractListener implements ListenerAggregateInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @param ConfigurationInterface $configuration
     * @param ClientInterface $client
     */
    public function __construct(ConfigurationInterface $configuration, ClientInterface $client)
    {
        $this->configuration = $configuration;
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