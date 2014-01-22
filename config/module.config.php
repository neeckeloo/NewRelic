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
        'factories' => array(
            'NewRelic\BackgroundJobListener'      => 'NewRelic\Service\BackgroundJobListenerFactory',
            'NewRelic\Client'                     => 'NewRelic\Service\ClientFactory',
            'NewRelic\ModuleOptions'              => 'NewRelic\Service\ModuleOptionsFactory',
            'NewRelic\ErrorListener'              => 'NewRelic\Service\ErrorListenerFactory',
            'NewRelic\Logger'                     => 'NewRelic\Service\LoggerFactory',
            'NewRelic\IgnoredTransactionListener' => 'NewRelic\Service\IgnoredTransactionListenerFactory',
            'NewRelic\Log\Writer'                 => 'NewRelic\Service\LogWriterFactory',
        ),
    ),
);
