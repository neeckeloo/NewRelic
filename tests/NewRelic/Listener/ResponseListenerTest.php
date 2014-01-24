<?php
namespace NewRelic\Listener;

use NewRelic\Client;
use NewRelic\ModuleOptions;
use Zend\EventManager\EventManager;
use Zend\Mvc\MvcEvent;

class ResponseListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var Client
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
        $this->listener = new ResponseListener();

        $this->moduleOptions = new ModuleOptions();
        $this->listener->setModuleOptions($this->moduleOptions);

        $this->event = new MvcEvent();
    }

    public function testOnResponseWithoutAutoInstrument()
    {
        $this->moduleOptions
            ->setBrowserTimingEnabled(true)
            ->setBrowserTimingAutoInstrument(false);

        $client = $this->getMock('NewRelic\Client');
        $this->listener->setClient($client);
        
        $client
            ->expects($this->once())
            ->method('getBrowserTimingHeader')
            ->will($this->returnValue('<div class="browser-timing-header"></div>'));
        $client
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

        $client = $this->getMock('NewRelic\Client');
        $this->listener->setClient($client);

        $client
            ->expects($this->once())
            ->method('disableAutorum');
        $client
            ->expects($this->never())
            ->method('getBrowserTimingHeader');
        $client
            ->expects($this->never())
            ->method('getBrowserTimingFooter');

        $this->listener->onResponse($this->event);
    }

    public function testOnResponseNotInHttpRequestContext()
    {
        $this->moduleOptions->setBrowserTimingEnabled(true);

        $client = $this->getMock('NewRelic\Client');
        $this->listener->setClient($client);

        $client
            ->expects($this->once())
            ->method('disableAutorum');
        $client
            ->expects($this->never())
            ->method('getBrowserTimingHeader');
        $client
            ->expects($this->never())
            ->method('getBrowserTimingFooter');

        $request = new \Zend\Stdlib\Request();
        $this->event->setRequest($request);

        $this->listener->onResponse($this->event);
    }

    public function testOnResponseInAjaxHttpRequestContext()
    {
        $this->moduleOptions->setBrowserTimingEnabled(true);

        $client = $this->getMock('NewRelic\Client');
        $this->listener->setClient($client);

        $client
            ->expects($this->once())
            ->method('disableAutorum');
        $client
            ->expects($this->never())
            ->method('getBrowserTimingHeader');
        $client
            ->expects($this->never())
            ->method('getBrowserTimingFooter');

        $request = $this->getMock('Zend\Http\Request');
        $request
            ->expects($this->once())
            ->method('isXmlHttpRequest')
            ->will($this->returnValue(true));
        $this->event->setRequest($request);

        $this->listener->onResponse($this->event);
    }

    public function testAttachAndDetachListener()
    {
        $events = new EventManager();
        $events->attach($this->listener);

        $listeners = $events->getListeners(MvcEvent::EVENT_FINISH);
        $this->assertEquals(1, count($listeners));

        $events->detach($this->listener);
        
        $listeners = $events->getListeners(MvcEvent::EVENT_FINISH);
        $this->assertEquals(0, count($listeners));
    }
}