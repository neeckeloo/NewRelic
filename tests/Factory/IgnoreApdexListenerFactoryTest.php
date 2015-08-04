<?php
namespace NewRelicTest\Factory;

use NewRelic\Factory\IgnoreApdexListenerFactory;
use NewRelic\Listener\IgnoreApdexListener;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

class IgnoreApdexListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IgnoreApdexListenerFactory
     */
    protected $ignoreApdexListenerFactory;

    public function setUp()
    {
        $this->ignoreApdexListenerFactory = new IgnoreApdexListenerFactory();
    }

    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService(ModuleOptions::class, new ModuleOptions());

        $listener = $this->ignoreApdexListenerFactory->createService($serviceManager);
        $this->assertInstanceOf(IgnoreApdexListener::class, $listener);
    }
}
