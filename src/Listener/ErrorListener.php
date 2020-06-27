<?php

declare(strict_types=1);

namespace NewRelic\Listener;

use Laminas\EventManager\EventManagerInterface as Events;
use Laminas\Mvc\MvcEvent;
use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use Psr\Log\LoggerInterface;
use Throwable;

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
