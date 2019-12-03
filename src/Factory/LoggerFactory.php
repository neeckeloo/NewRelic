<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\NewRelicHandler;

class LoggerFactory
{
    public function __invoke(ContainerInterface $container): Logger
    {
        $logger = new Logger('newrelic');
        $logger->pushHandler(new NewRelicHandler());

        return $logger;
    }
}
