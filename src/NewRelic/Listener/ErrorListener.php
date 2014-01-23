<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\Log\LoggerInterface;
use Zend\Mvc\MvcEvent;

class ErrorListener extends AbstractListener
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param  Events $events
     * @return void
     */
    public function attach(Events $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR,
                                             array($this, 'onError'));
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR,
                                             array($this, 'onError'));
    }

    /**
     * @param  MvcEvent $event
     * @return void
     */
    public function onError(MvcEvent $event)
    {
        $exception = $event->getParam('exception');
        if (!$exception) {
            return;
        }

        $message = $exception->getFile()
            . ":" . $exception->getLine()
            . ": " . $exception->getMessage();
        
        $this->logger->err($message, array('exception' => $exception));
    }
}
