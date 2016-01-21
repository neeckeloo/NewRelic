<?php
namespace NewRelicTest;

use NewRelic\Client;
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

        $application = new Application([], $serviceManager);
        $event->setApplication($application);

        return $event;
    }

    public function testShouldAttachListenersOnBootstrap()
    {
        $listeners = [
            'NewRelic\RequestListener',
            'NewRelic\ResponseListener',
        ];

        $client = $this->getMock(Client::class);
        $client
            ->expects($this->once())
            ->method('extensionLoaded')
            ->will($this->returnValue(true));

        $moduleOptions = new ModuleOptions([
            'listeners' => $listeners,
        ]);

        $eventManager = $this->getMock(EventManager::class);
        $eventManager
            ->expects($this->exactly(count($listeners)))
            ->method('attach');

        $mvcEvent = $this->getMvcEvent($eventManager);

        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        $serviceManager->setService(Client::class, $client);
        $serviceManager->setService(ModuleOptions::class, $moduleOptions);
        $serviceManager->setService(
            'NewRelic\RequestListener',
            new RequestListener($client, $moduleOptions)
        );
        $serviceManager->setService(
            'NewRelic\ResponseListener',
            new ResponseListener($client, $moduleOptions)
        );

        $module = new Module();
        $module->onBootstrap($mvcEvent);
    }
}