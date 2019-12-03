<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use Psr\Log\LoggerInterface;
use Throwable;
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
    public function attach(Events $events, $priority = 1): void
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

    public function onError(MvcEvent $event): void
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

    private function createLogMessageFromException(Throwable $exception): string
    {
        return $exception->getFile()
            . ":" . $exception->getLine()
            . ": " . $exception->getMessage();
    }
}
