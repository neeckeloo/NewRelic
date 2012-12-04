<?php
namespace NewRelic\Service;

class ManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Manager
     */
    protected $managerFactory;

    public function setUp()
    {
        $this->managerFactory = new ManagerFactory();
    }

    public function testCreateService()
    {
        $config = array(
            'newrelic' => array(
                'application' => array(
                    'name' => 'foo',
                    'license' => '',
                ),
                'browser_timing' => array(
                    'enabled' => false,
                    'auto_instrument' => true,
                )
            ),
        );
        
        $serviceManager = $this->getMock(
            'Zend\ServiceManager\ServiceManager',
            array('get'), array(), '', false
        );

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($config));

        $manager = $this->managerFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Manager', $manager);

        $this->assertEquals('foo', $manager->getApplicationName());
        $this->assertFalse($manager->getBrowserTimingEnabled());
        $this->assertTrue($manager->getBrowserTimingAutoInstrument());
    }
}