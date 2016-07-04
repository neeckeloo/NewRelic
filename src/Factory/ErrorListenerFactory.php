<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Listener\ErrorListener;

class ErrorListenerFactory
{
    public function __invoke(ContainerInterface $serviceLocator)
    {
        $client  = $serviceLocator->get('NewRelic\Client');
        $options = $serviceLocator->get('NewRelic\ModuleOptions');
        $logger  = $serviceLocator->get('NewRelic\Logger');

        return new ErrorListener($client, $options, $logger);
    }
}
