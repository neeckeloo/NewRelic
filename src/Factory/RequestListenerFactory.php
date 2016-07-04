<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Listener\RequestListener;

class RequestListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');

        return new RequestListener($client, $options);
    }
}
