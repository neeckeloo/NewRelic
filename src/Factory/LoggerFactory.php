<?php
namespace NewRelic\Factory;

use Monolog\Logger;
use Monolog\Handler\NewRelicHandler;

class LoggerFactory
{
    public function __invoke()
    {
        $logger = new Logger('newrelic');
        $logger->pushHandler(new NewRelicHandler());

        return $logger;
    }
}
