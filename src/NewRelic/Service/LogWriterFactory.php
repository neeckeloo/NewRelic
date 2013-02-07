<?php
namespace NewRelic\Service;

use NewRelic\Log\Writer\NewRelic as LogWriter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic log writer factory
 */
class LogWriterFactory implements FactoryInterface
{
    /**
     * Create the NewRelic log writer
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return LogWriter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $client = $serviceLocator->get('NewRelic\Client');
        $writer = new LogWriter($client);

        return $writer;
    }
}