<?php
namespace NewRelic\Service;

use NewRelic\Listener\ErrorListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic error listener factory
 */
class ErrorListenerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ErrorListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $moduleOptions = $serviceLocator->get('NewRelic\ModuleOptions');
        $client = $serviceLocator->get('NewRelic\Client');
        $logger = $serviceLocator->get('NewRelic\Logger');

        return new ErrorListener($moduleOptions, $client, $logger);
    }
}