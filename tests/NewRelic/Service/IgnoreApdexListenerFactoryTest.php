<?php
namespace NewRelic\Service;

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
        $serviceManager->setService('NewRelic\ModuleOptions', new ModuleOptions());

        $listener = $this->ignoreApdexListenerFactory->createService($serviceManager);
        $this->assertInstanceOf('NewRelic\Listener\IgnoreApdexListener', $listener);
    }
}