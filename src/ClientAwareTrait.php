<?php
namespace NewRelic;

use NewRelic\ClientInterface;

trait ClientAwareTrait
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}
