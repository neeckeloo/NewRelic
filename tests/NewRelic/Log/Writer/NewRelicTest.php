<?php
namespace NewRelic\Log\Writer;

class NewRelicTest extends \PHPUnit_Framework_TestCase
{
    public function testSetClient()
    {
        $client = $this->getMock('NewRelic\Client', array(), array(), '', false);
        $client
            ->expects($this->once())
            ->method('noticeError');

        $writer = new NewRelic($client);
        $writer->write(array(
            'message' => 'foo',
        ));
    }
}