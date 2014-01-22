<?php
namespace NewRelic\Service;

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
        $config = array(
            'newrelic' => array(
                'application_name' => null,
                'license' => null,
                'browser_timing_enabled' => false,
                'browser_timing_auto_instrument' => true,
            ),
        );

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($config));

        $moduleOptions = $this->moduleOptionsFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\ModuleOptions', $moduleOptions);
    }
}