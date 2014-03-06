<?php
namespace NewRelic\Factory;

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
        $serviceManager->setService('Config', array(
            'newrelic' => array(
                'application_name' => null,
                'license' => null,
                'browser_timing_enabled' => false,
                'browser_timing_auto_instrument' => true,
            ),
        ));

        $moduleOptions = $this->moduleOptionsFactory->createService($serviceManager);
        $this->assertInstanceOf('NewRelic\ModuleOptions', $moduleOptions);
    }
}