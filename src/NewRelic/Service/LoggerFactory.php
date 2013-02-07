<?php
namespace NewRelic\Service;

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
     * @return \Zend\Log\Logger
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $logger = new \Zend\Log\Logger();

        $writer = $serviceLocator->get('NewRelic\Log\Writer');
        $logger->addWriter($writer);

        return $logger;
    }
}