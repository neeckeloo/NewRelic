<?php
namespace NewRelic\Factory;

use Zend\Log\Logger;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic logger factory
 */
class LoggerFactory implements FactoryInterface
{
    /**
     * Create the NewRelic logger
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Logger
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $logger = new Logger();

        $writer = $serviceLocator->get('NewRelic\Log\Writer');
        $logger->addWriter($writer);

        return $logger;
    }
}