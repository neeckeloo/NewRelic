<?php
namespace NewRelic\Service;

class ConfigurationFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigurationFactory
     */
    protected $configurationFactory;

    public function setUp()
    {
        $this->configurationFactory = new ConfigurationFactory();
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

        $configuration = $this->configurationFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Configuration', $configuration);
    }
}