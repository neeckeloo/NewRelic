<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Listener\BackgroundJobListener;
use NewRelic\TransactionMatcher;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BackgroundJobListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');
        $transactionMatcher = new TransactionMatcher($options->getBackgroundJobs());

        return new BackgroundJobListener($client, $options, $transactionMatcher);
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return BackgroundJobListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, BackgroundJobListener::class);
    }
}
