<?php
namespace NewRelic\Factory;

use Zend\Log\Logger;
use Zend\Log\Processor\PsrPlaceholder as PsrPlaceholderProcessor;
use Zend\Log\PsrLoggerAdapter;

class LoggerFactory
{
    public function __invoke($serviceLocator)
    {
        $logger = new Logger();

        $writer = $serviceLocator->get('NewRelic\Log\Writer');
        $logger->addWriter($writer);

        $logger->addProcessor(new PsrPlaceholderProcessor);

        return new PsrLoggerAdapter($logger);
    }
}
