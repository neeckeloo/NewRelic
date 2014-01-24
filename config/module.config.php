<?php
return array(
    'newrelic' => array(
        'application_name' => null,
        'license' => null,
        'browser_timing_enabled' => false,
        'browser_timing_auto_instrument' => true,
        'exceptions_logging_enabled' => false,
    ),
    'service_manager' => array(
        'invokables' => array(
            'NewRelic\Client'           => 'NewRelic\Client',
            'NewRelic\Log\Writer'       => 'NewRelic\Log\Writer\NewRelic',
            'NewRelic\RequestListener'  => 'NewRelic\Listener\RequestListener',
            'NewRelic\ResponseListener' => 'NewRelic\Listener\ResponseListener',
        ),
        'factories' => array(
            'NewRelic\BackgroundJobListener'     => 'NewRelic\Service\BackgroundJobListenerFactory',
            'NewRelic\ModuleOptions'             => 'NewRelic\Service\ModuleOptionsFactory',
            'NewRelic\ErrorListener'             => 'NewRelic\Service\ErrorListenerFactory',
            'NewRelic\Logger'                    => 'NewRelic\Service\LoggerFactory',
            'NewRelic\IgnoreApdexListener'       => 'NewRelic\Service\IgnoreApdexListenerFactory',
            'NewRelic\IgnoreTransactionListener' => 'NewRelic\Service\IgnoreTransactionListenerFactory',
        ),
    ),
);
