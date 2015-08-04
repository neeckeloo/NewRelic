<?php
namespace NewRelicTest\Factory;

use NewRelic\Factory\BackgroundJobListenerFactory;
use NewRelic\Listener\BackgroundJobListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

class BackgroundJobListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BackgroundJobListenerFactory
     */
    protected $backgroundJobListenerFactory;

    public function setUp()
    {
        $this->backgroundJobListenerFactory = new BackgroundJobListenerFactory();
    }

    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(ModuleOptions::class, new ModuleOptions());

        $listener = $this->backgroundJobListenerFactory->createService($serviceManager);
        $this->assertInstanceOf(BackgroundJobListener::class, $listener);
    }
}
