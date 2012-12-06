<?php
namespace NewRelic\Service;

class ClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientFactory
     */
    protected $clientFactory;

    public function setUp()
    {
        $this->clientFactory = new ClientFactory();
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

        $serviceManager = $this->getMock(
            'Zend\ServiceManager\ServiceManager',
            array('get'), array(), '', false
        );

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($config));

        $client = $this->clientFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Client', $client);
    }
}