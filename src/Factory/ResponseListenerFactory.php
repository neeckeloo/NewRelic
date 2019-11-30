<?php
namespace NewRelic\Factory;

use Psr\Container\ContainerInterface;
use NewRelic\Listener\ResponseListener;

class ResponseListenerFactor
{
    public function __invoke(ContainerInterface $container): ResponseListener
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');

        return new ResponseListener($client, $options);
    }
}
