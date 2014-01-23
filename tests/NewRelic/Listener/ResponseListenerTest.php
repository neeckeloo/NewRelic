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

        $client = $this->getMockBuilder('NewRelic\Client')
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->any())
            ->method('getBrowserTimingHeader')
            ->will($this->returnValue('<div class="browser-timing-header"></div>'));
        $client
            ->expects($this->any())
            ->method('getBrowserTimingFooter')
            ->will($this->returnValue('<div class="browser-timing-footer"></div>'));
        $this->listener->setClient($client);

        $this->event = new MvcEvent();
    }

    public function testOnResponseWithoutAutoInstrument()
    {
        $this->moduleOptions
            ->setBrowserTimingEnabled(true)
            ->setBrowserTimingAutoInstrument(false);

        $response = new \Zend\Stdlib\Response();
        $response->setContent('<html><head></head><body></body></html>');
        $this->event->setResponse($response);
        $this->listener->onResponse($this->event);

        $response = $this->event->getResponse();
        $this->assertInstanceOf('Zend\Stdlib\Response', $response);

        $content = $response->getContent();
        $this->assertContains('<head><div class="browser-timing-header"></div></head>', $content);
        $this->assertContains('<body><div class="browser-timing-footer"></div></body>', $content);
    }

    public function testOnResponseWithBrowserTimingDisabled()
    {
        $this->moduleOptions
            ->setBrowserTimingEnabled(false);

        $response = new \Zend\Stdlib\Response();
        $response->setContent('<html><head></head><body></body></html>');
        $this->event->setResponse($response);
        $this->listener->onResponse($this->event);

        $response = $this->event->getResponse();
        $this->assertInstanceOf('Zend\Stdlib\Response', $response);

        $content = $response->getContent();
        $this->assertNotContains('<head><div class="browser-timing-header"></div></head>', $content);
        $this->assertNotContains('<body><div class="browser-timing-footer"></div></body>', $content);
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