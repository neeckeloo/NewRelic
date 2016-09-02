<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Listener\IgnoreApdexListener;
use NewRelic\TransactionMatcher;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IgnoreApdexListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');
        $transactionMatcher = new TransactionMatcher($options->getIgnoredApdex());

        return new IgnoreApdexListener($client, $options, $transactionMatcher);
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return IgnoreApdexListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, IgnoreApdexListener::class);
    }
}
