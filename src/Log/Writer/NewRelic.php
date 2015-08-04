<?php
namespace NewRelic\Log\Writer;

use Zend\Log\Writer\AbstractWriter;
use NewRelic\ClientAwareInterface;
use NewRelic\ClientAwareTrait;

class NewRelic extends AbstractWriter implements ClientAwareInterface
{
    use ClientAwareTrait;

    /**
     * Write a message to NewRelic.
     *
     * @param  array $event event data
     * @return void
     */
    protected function doWrite(array $event)
    {
        $exception = isset($event['extra']['exception'])
            ? $event['extra']['exception'] : null;
        $this->client->noticeError($event['message'], $exception);
    }
}
