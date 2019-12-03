<?php

use NewRelic\Client;
use NewRelic\Factory;
use NewRelic\Listener;
use NewRelic\ModuleOptions;
use NewRelic\TransactionNameProvider\RouteNameProvider;

return [
    'newrelic' => [
        'application_name' => getenv('NEW_RELIC_APP_NAME') ?: null,
        'license' => getenv('NEW_RELIC_LICENSE_KEY ') ?: null,
        'browser_timing_enabled' => false,
        'browser_timing_auto_instrument' => true,
        'exceptions_logging_enabled' => false,
        'listeners' => [
            Listener\BackgroundJobListener::class,
            Listener\ErrorListener::class,
            Listener\IgnoreApdexListener::class,
            Listener\IgnoreTransactionListener::class,
            Listener\RequestListener::class,
            Listener\ResponseListener::class,
        ],
        'transaction_name_provider' => RouteNameProvider::class,
    ],
    'service_manager' => [
        'invokables' => [
            Client::class => Client::class,
        ],
        'factories' => [
            Listener\BackgroundJobListener::class => Factory\BackgroundJobListenerFactory::class,
            Listener\ErrorListener::class => Factory\ErrorListenerFactory::class,
            Listener\IgnoreApdexListener::class => Factory\IgnoreApdexListenerFactory::class,
            Listener\IgnoreTransactionListener::class => Factory\IgnoreTransactionListenerFactory::class,
            Listener\RequestListener::class => Factory\RequestListenerFactory::class,
            Listener\ResponseListener::class => Factory\ResponseListenerFactory::class,
            ModuleOptions::class => Factory\ModuleOptionsFactory::class,
            'NewRelic\Logger' => Factory\LoggerFactory::class,
        ],
    ],
];
