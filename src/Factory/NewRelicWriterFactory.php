<?php
namespace NewRelic\Factory;

use NewRelic\Log\Writer\NewRelic as NewRelicWriter;

class NewRelicWriterFactory
{
    public function __invoke($serviceLocator)
    {
        $client = $serviceLocator->get('NewRelic\Client');

        return new NewRelicWriter($client);
    }
}
