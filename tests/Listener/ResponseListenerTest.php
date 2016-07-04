<?php
namespace NewRelicTest\Listener;

use NewRelic\ClientInterface;
use NewRelic\Listener\ResponseListener;
use NewRelic\ModuleOptions;
use Zend\EventManager\EventManager;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\Request;

class ResponseListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var ResponseListener
     */
    protected $listener;

    /**
     * @var MvcEvent
     */
    protected $event;

    public function setUp()
    {
        $this->client = $this->getMock(ClientInterface::class);
        $this->moduleOptions = new ModuleOptions();
        $this->listener = new ResponseListener($this->client, $this->moduleOptions);

        $this->event = new MvcEvent();
    }

    public function testOnResponseWithoutAutoInstrument()
    {
        $this->moduleOptions
            ->setBrowserTimingEnabled(true)
            ->setBrowserTimingAutoInstrument(false);

        $this->client
            ->expects($this->once())
            ->method('getBrowserTimingHeader')
            ->will($this->returnValue('<div class="browser-timing-header"></div>'));
        $this->client
            ->expects($this->once())
            ->method('getBrowserTimingFooter')
            ->will($this->returnValue('<div class="browser-timing-footer"></div>'));

        $request = new \Zend\Http\Request();
        $this->event->setRequest($request);

        $response = new \Zend\Stdlib\Response();
        $response->setContent('<html><head></head><body></body></html>');
        $this->event->setResponse($response);
        $this->listener->onResponse($this->event);

        $content = $response->getContent();
        $this->assertContains('<head><div class="browser-timing-header"></div></head>', $content);
        $this->assertContains('<body><div class="browser-timing-footer"></div></body>', $content);
    }

    public function testOnResponseWithBrowserTimingDisabled()
    {
        $this->moduleOptions->setBrowserTimingEnabled(false);

        $this->client
            ->expects($this->once())
            ->method('disableAutorum');
        $this->client
            ->expects($this->never())
            ->method('getBrowserTimingHeader');
        $this->client
            ->expects($this->never())
            ->method('getBrowserTimingFooter');

        $this->listener->onResponse($this->event);
    }

    public function testOnResponseNotInHttpRequestContext()
    {
        $this->moduleOptions->setBrowserTimingEnabled(true);

        $this->client
            ->expects($this->once())
            ->method('disableAutorum');
        $this->client
            ->expects($this->never())
            ->method('getBrowserTimingHeader');
        $this->client
            ->expects($this->never())
            ->method('getBrowserTimingFooter');

        $request = new Request();
        $this->event->setRequest($request);

        $this->listener->onResponse($this->event);
    }

    public function testOnResponseInAjaxHttpRequestContext()
    {
        $this->moduleOptions->setBrowserTimingEnabled(true);

        $this->client
            ->expects($this->once())
            ->method('disableAutorum');
        $this->client
            ->expects($this->never())
            ->method('getBrowserTimingHeader');
        $this->client
            ->expects($this->never())
            ->method('getBrowserTimingFooter');

        $request = $this->getMock(HttpRequest::class);
        $request
            ->expects($this->once())
            ->method('isXmlHttpRequest')
            ->will($this->returnValue(true));
        $this->event->setRequest($request);

        $this->listener->onResponse($this->event);
    }
}
