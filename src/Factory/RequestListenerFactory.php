<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Listener\RequestListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RequestListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');

        return new RequestListener($client, $options);
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return RequestListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, RequestListener::class);
    }
}
