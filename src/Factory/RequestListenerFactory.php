<?php
namespace NewRelic\Factory;

use NewRelic\Listener\RequestListener;

class ResponseListenerFactory
{
    public function __invoke($serviceLocator)
    {
        $client  = $serviceLocator->get('NewRelic\Client');
        $options = $serviceLocator->get('NewRelic\ModuleOptions');

        return new RequestListener($client, $options);
    }
}
