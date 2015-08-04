<?php
namespace NewRelicTest\Log\Writer;

use NewRelic\Log\Writer\NewRelic as NewRelicLogWriter;

class NewRelicTest extends \PHPUnit_Framework_TestCase
{
    public function testMessageLogged()
    {
        $loggedMessage = "foo";
        
        $client = $this->getMockBuilder('NewRelic\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->once())
            ->method('noticeError')
            ->with($this->equalTo($loggedMessage));

        $writer = new NewRelicLogWriter();
        $writer->setClient($client);
        
        $writer->write([
            'message' => $loggedMessage,
        ]);
    }

    public function testExceptionAndMessageLogged()
    {
        $loggedMessage = "foo";
        $loggedError = new \Exception();

        $client = $this->getMockBuilder('NewRelic\Client')
            ->disableOriginalConstructor()
            ->getMock();
        
        $client
            ->expects($this->once())
            ->method('noticeError')
            ->with($this->equalTo($loggedMessage), $this->equalTo($loggedError));

        $writer = new NewRelicLogWriter();
        $writer->setClient($client);

        $writer->write([
            'message' => $loggedMessage,
            'extra' => [
                'exception' => $loggedError,
            ],
        ]);
    }
}
