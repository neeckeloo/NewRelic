<?php
namespace NewRelicTest;

use NewRelic\Module;
use NewRelic\ModuleOptions;
use NewRelic\Listener\RequestListener;
use NewRelic\Listener\ResponseListener;
use Zend\EventManager\EventManager;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param  EventManager $em
     * @return MvcEvent
     */
    protected function getMvcEvent($em)
    {
        $event = new MvcEvent();
        
        $serviceManager = new ServiceManager();
        $serviceManager
            ->setService('EventManager', $em)
            ->setService('Request', new HttpRequest())
            ->setService('Response', new HttpResponse());
        
        $application = new Application(array(), $serviceManager);
        $event->setApplication($application);
        
        return $event;
    }
    
    public function testShouldAttachListenersOnBootstrap()
    {        
        $client = $this->getMock('NewRelic\Client');
        $client
            ->expects($this->once())
            ->method('extensionLoaded')
            ->will($this->returnValue(true));
        
        $listeners = array(
            'NewRelic\RequestListener' => new RequestListener(),
            'NewRelic\ResponseListener' => new ResponseListener(),
        );
        
        $eventManager = $this->getMock('Zend\EventManager\EventManager');
        $eventManager
            ->expects($this->exactly(count($listeners)))
            ->method('attach');
        
        $mvcEvent = $this->getMvcEvent($eventManager);
        
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        $serviceManager->setService('NewRelic\Client', $client);
        
        $moduleOptions = new ModuleOptions(array(
            'listeners' => array_keys($listeners),
        ));
        $serviceManager->setService('NewRelic\ModuleOptions', $moduleOptions);
        
        foreach ($listeners as $key => $value) {
            $serviceManager->setService($key, $value);
        }
        
        $module = new Module();
        $module->onBootstrap($mvcEvent);
    }
}