<?php
namespace NewRelic\Service;

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
        $serviceManager->setService('NewRelic\ModuleOptions', new ModuleOptions());

        $listener = $this->backgroundJobListenerFactory->createService($serviceManager);
        $this->assertInstanceOf('NewRelic\Listener\BackgroundJobListener', $listener);
    }
}