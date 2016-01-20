<?php
namespace NewRelic\Factory;

use Zend\Log\Logger;
use Zend\Log\Processor\PsrPlaceholder as PsrPlaceholderProcessor;
use Zend\Log\PsrLoggerAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic logger factory
 */
class LoggerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return \Psr\Log\LoggerInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $logger = new Logger();

        $writer = $serviceLocator->get('NewRelic\Log\Writer');
        $logger->addWriter($writer);

        $logger->addProcessor(new PsrPlaceholderProcessor);

        return new PsrLoggerAdapter($logger);
    }
}
