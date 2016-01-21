<?php
namespace NewRelic\Log\Writer;

use Zend\Log\Exception;
use Zend\Log\Writer\AbstractWriter;
use NewRelic\ClientInterface;

class NewRelic extends AbstractWriter
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param null|ClientInterface|array|Traversable $instance
     */
    public function __construct($instance = null)
    {
        if ($instance instanceof Traversable) {
            $instance = iterator_to_array($instance);
        }

        if (is_array($instance)) {
            parent::__construct($instance);
            $instance = isset($instance['instance']) ? $instance['instance'] : null;
        }

        if ($instance !== null && !($instance instanceof ClientInterface)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'You must pass a valid %s',
                ClientInterface::class
            ));
        }

        $this->client = $instance;
    }

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
