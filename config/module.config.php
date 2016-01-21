<?php
return [
    'newrelic' => [
        'application_name' => null,
        'license' => null,
        'browser_timing_enabled' => false,
        'browser_timing_auto_instrument' => true,
        'exceptions_logging_enabled' => false,
        'listeners' => [
            'NewRelic\BackgroundJobListener',
            'NewRelic\ErrorListener',
            'NewRelic\IgnoreApdexListener',
            'NewRelic\IgnoreTransactionListener',
            'NewRelic\RequestListener',
            'NewRelic\ResponseListener',
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'NewRelic\Client'           => 'NewRelic\Client',
            'NewRelic\RequestListener'  => 'NewRelic\Listener\RequestListener',
            'NewRelic\ResponseListener' => 'NewRelic\Listener\ResponseListener',
        ],
        'factories' => [
            'NewRelic\BackgroundJobListener'     => 'NewRelic\Factory\BackgroundJobListenerFactory',
            'NewRelic\ModuleOptions'             => 'NewRelic\Factory\ModuleOptionsFactory',
            'NewRelic\ErrorListener'             => 'NewRelic\Factory\ErrorListenerFactory',
            'NewRelic\Logger'                    => 'NewRelic\Factory\LoggerFactory',
            'NewRelic\IgnoreApdexListener'       => 'NewRelic\Factory\IgnoreApdexListenerFactory',
            'NewRelic\IgnoreTransactionListener' => 'NewRelic\Factory\IgnoreTransactionListenerFactory',
        ],
    ],
];
