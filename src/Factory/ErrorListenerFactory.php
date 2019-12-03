<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use Psr\Container\ContainerInterface;
use NewRelic\Listener\ErrorListener;

class ErrorListenerFactory
{
    public function __invoke(ContainerInterface $container): ErrorListener
    {
        $client  = $container->get('NewRelic\Client');
        $options = $container->get('NewRelic\ModuleOptions');
        $logger  = $container->get('NewRelic\Logger');

        return new ErrorListener($client, $options, $logger);
    }
}
