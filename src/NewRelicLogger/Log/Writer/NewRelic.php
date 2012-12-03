<?php
namespace NewRelicLogger\Log\Writer;

use Zend\Log\Writer\AbstractWriter;

class NewRelic extends AbstractWriter
{
    /**
     * Write a message to NewRelic.
     *
     * @param array $event event data
     * @return void
     */
    protected function doWrite(array $event)
    {
        if (extension_loaded('newrelic')) {
            newrelic_notice_error($event['message']);
        }
    }
}