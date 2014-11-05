<?php
namespace NewRelic\Listener;

use NewRelic\ClientAwareInterface;
use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsAwareInterface;
use NewRelic\ModuleOptionsInterface;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\EventManager\ListenerAggregateInterface;

abstract class AbstractListener implements ClientAwareInterface, ListenerAggregateInterface, ModuleOptionsAwareInterface
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
     */
    public function setModuleOptions(ModuleOptionsInterface $options)
    {
        $this->options = $options;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
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