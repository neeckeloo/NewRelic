<?php
namespace NewRelic\Log\Writer;

use Zend\Log\Writer\AbstractWriter;
use NewRelic\Client;

class NewRelic extends AbstractWriter
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Write a message to NewRelic.
     *
     * @param array $event event data
     * @return void
     */
    protected function doWrite(array $event)
    {
        $this->client->noticeError($event['message']);
    }
}