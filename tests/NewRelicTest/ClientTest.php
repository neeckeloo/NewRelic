<?php
namespace NewRelicTest;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        $this->client = $this->getMockBuilder('NewRelic\Client')
            ->setMethods(array('extensionLoaded'))
            ->getMock();

        $this->client
            ->expects($this->once())
            ->method('extensionLoaded');
    }

    public function testSetAppName()
    {
        $this->client->setAppName('foo');
    }

    public function testGetBrowserTimingHeader()
    {
        $this->client->getBrowserTimingHeader();
    }

    public function testGetBrowserTimingFooter()
    {
        $this->client->getBrowserTimingFooter();
    }

    public function testNoticeError()
    {
        $this->client->noticeError('foo');
    }

    public function testNameTransaction()
    {
        $this->client->nameTransaction('foo');
    }

    public function testEndOfTransaction()
    {
        $this->client->endOfTransaction();
    }

    public function testIgnoreTransaction()
    {
        $this->client->ignoreTransaction();
    }

    public function testIgnoreApdex()
    {
        $this->client->ignoreApdex();
    }

    public function testBackgroundJob()
    {
        $this->client->backgroundJob();
    }

    public function testCaptureParams()
    {
        $this->client->captureParams();
    }

    public function testAddCustomMetric()
    {
        $this->client->addCustomMetric('foo', 123);
    }

    public function testAddCustomParameter()
    {
        $this->client->addCustomParameter('foo', 123);
    }

    public function testAddCustomTracer()
    {
        $this->client->addCustomTracer('foo');
    }

    public function testDisableAutorum()
    {
        $this->client->disableAutorum();
    }
}