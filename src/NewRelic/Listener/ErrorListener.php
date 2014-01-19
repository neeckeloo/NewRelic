<?php
namespace NewRelic\Listener;

use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class ErrorListener extends AbstractListener
{
    /**
     * @param Events $events
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
     * @param MvcEvent $event
     * @return void
     */
    public function onError(MvcEvent $event)
    {
        $exception = $event->getResult()->exception;
        if (!$exception) {
            return;
        }

        $serviceManager = $event->getApplication()->getServiceManager();

        $logger = $serviceManager->get('NewRelic\ExceptionLogger');
        $message
            = $exception->getFile()
            . ":" . $exception->getLine()
            . ": " . $exception->getMessage();
        $logger->err($message, array('exception' => $exception));
    }
}
