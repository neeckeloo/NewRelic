<?php
namespace NewRelic\Factory;

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
        $logger = $serviceLocator->get('NewRelic\Logger');

        return new ErrorListener($logger);
    }
}