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
     * @return \NewRelic\Log\Writer\NewRelic
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Write a message to NewRelic.
     *
     * @param array $event event data
     * @return void
     */
    protected function doWrite(array $event)
    {
        $this->getClient()->noticeError($event['message']);
    }
}