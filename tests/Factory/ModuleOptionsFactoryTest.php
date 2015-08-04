<?php
namespace NewRelicTest\Factory;

use NewRelic\Factory\ModuleOptionsFactory;
use NewRelic\ModuleOptions;
use Zend\ServiceManager\ServiceManager;

class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptionsFactory
     */
    protected $moduleOptionsFactory;

    public function setUp()
    {
        $this->moduleOptionsFactory = new ModuleOptionsFactory();
    }

    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', [
            'newrelic' => [
                'application_name' => null,
                'license' => null,
                'browser_timing_enabled' => false,
                'browser_timing_auto_instrument' => true,
            ],
        ]);

        $moduleOptions = $this->moduleOptionsFactory->createService($serviceManager);
        $this->assertInstanceOf(ModuleOptions::class, $moduleOptions);
    }

    /**
     * @expectedException \NewRelic\Exception\RuntimeException
     */
    public function testCreateServiceWithoutConfig()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', []);

        $this->moduleOptionsFactory->createService($serviceManager);
    }
}
