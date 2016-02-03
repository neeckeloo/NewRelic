<?php
namespace NewRelic\Factory;

use NewRelic\Listener\ResponseListener;

class ResponseListenerFactory
{
    public function __invoke($serviceLocator)
    {
        $client  = $serviceLocator->get('NewRelic\Client');
        $options = $serviceLocator->get('NewRelic\ModuleOptions');

        return new ResponseListener($client, $options);
    }
}
