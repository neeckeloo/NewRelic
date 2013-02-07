<?php
namespace NewRelic\Listener;

use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExceptionListener extends AbstractListener
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @param Client $client
     * @param ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function __construct(Client $client, ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct($client);
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param Events $events
     * @return void
     */
    public function attach(Events $events)
    {
        $this->listeners[] = $events->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onException'), 100);
    }

    /**
     * @param MvcEvent $e
     * @return void
     */
    public function onException(MvcEvent $e)
    {
        if ($e->getParam('exception')) {
            $this->serviceLocator->get('Zend\Log\Logger')->err($e->getParam('exception'));
        }
    }
}