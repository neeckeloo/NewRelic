<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Listener\ResponseListener;

class ResponseListenerFactory
{
    public function __invoke(ContainerInterface $serviceLocator)
    {
        $client  = $serviceLocator->get('NewRelic\Client');
        $options = $serviceLocator->get('NewRelic\ModuleOptions');

        return new ResponseListener($client, $options);
    }
}
