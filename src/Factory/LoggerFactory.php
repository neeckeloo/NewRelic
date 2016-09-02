<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\NewRelicHandler;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoggerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $logger = new Logger('newrelic');
        $logger->pushHandler(new NewRelicHandler());

        return $logger;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Logger
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, Logger::class);
    }
}
