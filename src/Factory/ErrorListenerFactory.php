<?php
namespace NewRelic\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Listener\ErrorListener;

class ErrorListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');
        $logger  = $container->get('NewRelic\Logger');

        return new ErrorListener($client, $options, $logger);
    }
}
