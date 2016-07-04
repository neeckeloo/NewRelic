<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Listener\RequestListener;

class ResponseListenerFactory
{
    public function __invoke(ContainerInterface $serviceLocator)
    {
        $client  = $serviceLocator->get('NewRelic\Client');
        $options = $serviceLocator->get('NewRelic\ModuleOptions');

        return new RequestListener($client, $options);
    }
}
