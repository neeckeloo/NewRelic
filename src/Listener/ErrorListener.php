<?php
namespace NewRelic\Listener;

use Exception;
use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use Psr\Log\LoggerInterface;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class ErrorListener extends AbstractListener
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        ClientInterface $client,
        ModuleOptionsInterface $options,
        LoggerInterface $logger
    ) {
        parent::__construct($client, $options);
        $this->logger = $logger;
    }

    /**
     * @param Events $events
     * @param int    $priority
     * @return void
     */
    public function attach(Events $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_DISPATCH_ERROR,
            [$this, 'onError']
        );
        $this->listeners[] = $events->attach(
            MvcEvent::EVENT_RENDER_ERROR,
            [$this, 'onError']
        );
    }

    /**
     * @param  MvcEvent $event
     * @return void
     */
    public function onError(MvcEvent $event)
    {
        if (!$this->options->getExceptionsLoggingEnabled()) {
            return;
        }

        $exception = $event->getParam('exception');
        if ($exception) {
            $message = $this->createLogMessageFromException($exception);
            $this->logger->error($message, ['exception' => $exception]);
        }
    }

    private function createLogMessageFromException(\Throwable $exception)
    {
        return $exception->getFile()
            . ":" . $exception->getLine()
            . ": " . $exception->getMessage();
    }
}
