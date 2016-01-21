<?php
namespace NewRelicTest\Log\Writer;

use Exception;
use NewRelic\Client;
use NewRelic\Log\Writer\NewRelic as NewRelicLogWriter;

class NewRelicTest extends \PHPUnit_Framework_TestCase
{
    public function testWriteGivenMessageShouldNoticeError()
    {
        $message = 'foo';

        $client = $this->getMock(Client::class);
        $client
            ->expects($this->once())
            ->method('noticeError')
            ->with($this->equalTo($message));

        $writer = new NewRelicLogWriter($client);

        $writer->write(['message' => $message]);
    }

    public function testWriteGivenMessageAndExceptionShouldNoticeError()
    {
        $message = 'foo';
        $exception = new Exception();

        $client = $this->getMock(Client::class);
        $client
            ->expects($this->once())
            ->method('noticeError')
            ->with($this->equalTo($message), $this->equalTo($exception));

        $writer = new NewRelicLogWriter($client);

        $writer->write([
            'message' => $message,
            'extra' => [
                'exception' => $exception,
            ],
        ]);
    }
}
