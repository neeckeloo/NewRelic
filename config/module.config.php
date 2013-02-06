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
            'NewRelicClient'    => 'NewRelic\Service\ClientFactory',
            'NewRelicLogWriter' => 'NewRelic\Service\LogWriterFactory',
            'Zend\Log\Logger'   => 'NewRelic\Service\LoggerFactory',
        ),
    ),
);