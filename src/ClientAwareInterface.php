<?php
namespace NewRelic;

interface ClientAwareInterface
{
    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client);
}