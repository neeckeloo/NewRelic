<?php
namespace NewRelic\Log\Writer;

class NewRelicTest extends \PHPUnit_Framework_TestCase
{
    public function testMessageLogged()
    {
        $loggedMessage = "foo";
        $client = $this->getMock('NewRelic\Client', array(), array(), '', false);
        $client
            ->expects($this->once())
            ->method('noticeError')
            ->with($this->equalTo($loggedMessage));

        $writer = new NewRelic($client);
        $writer->write(array(
            'message' => $loggedMessage,
        ));
    }

    public function testExceptionAndMessageLogged()
    {
        $loggedMessage = "foo";
        $loggedError = new \Exception();
        $client = $this->getMock('NewRelic\Client', array(), array(), '', false);
        $client
            ->expects($this->once())
            ->method('noticeError')
            ->with($this->equalTo($loggedMessage), $this->equalTo($loggedError));

        $writer = new NewRelic($client);
        $writer->write(array(
            'message' => $loggedMessage,
            'extra' => array(
                'exception' => $loggedError,
            ),
        ));
    }
}
