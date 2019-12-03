<?php
namespace NewRelicTest;

use NewRelic\Client;
use NewRelic\Module;
use NewRelic\ModuleOptions;
use NewRelic\Listener\RequestListener;
use NewRelic\Listener\ResponseListener;
use NewRelic\TransactionNameProvider\TransactionNameProviderInterface;
use PHPUnit\Framework\TestCase;
use Zend\EventManager\EventManager;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

class ModuleTest extends TestCase
{
    protected function getMvcEvent(EventManager $em): MvcEvent
    {
        $event = new MvcEvent();

        $serviceManager = new ServiceManager();
        $serviceManager->setService('EventManager', $em);
        $serviceManager->setService('Request', new HttpRequest());
        $serviceManager->setService('Response', new HttpResponse());

        $application = $this->createMock(ApplicationInterface::class);
        $application->method('getServiceManager')->willReturn($serviceManager);
        $application->method('getEventManager')->willReturn($em);

        $event->setApplication($application);

        return $event;
    }

    public function testShouldAttachListenersOnBootstrap()
    {
        $listeners = [
            'NewRelic\RequestListener',
            'NewRelic\ResponseListener',
        ];

        $client = $this->createMock(Client::class);
        $client
            ->expects($this->once())
            ->method('extensionLoaded')
            ->will($this->returnValue(true));

        $moduleOptions = new ModuleOptions([
            'listeners' => $listeners,
        ]);

        $eventManager = $this->createMock(EventManager::class);
        $eventManager
            ->expects($this->exactly(count($listeners)))
            ->method('attach');

        $mvcEvent = $this->getMvcEvent($eventManager);

        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        $serviceManager->setService(Client::class, $client);
        $serviceManager->setService(ModuleOptions::class, $moduleOptions);
        $serviceManager->setService(
            'NewRelic\RequestListener',
            new RequestListener($client, $moduleOptions, $this->getTransactionNameProvider())
        );
        $serviceManager->setService(
            'NewRelic\ResponseListener',
            new ResponseListener($client, $moduleOptions)
        );

        $module = new Module();
        $module->onBootstrap($mvcEvent);
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|TransactionNameProviderInterface
     */
    private function getTransactionNameProvider()
    {
        return $this->createMock(TransactionNameProviderInterface::class);
    }
}
