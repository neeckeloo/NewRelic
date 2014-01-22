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
        $moduleOptions = $this->getMock('NewRelic\ModuleOptions');

        $serviceManager = $this->getMockBuilder('Zend\ServiceManager\ServiceManager')
            ->disableOriginalConstructor()
            ->setMethods(array('get'))
            ->getMock();

        $serviceManager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($moduleOptions));

        $client = $this->clientFactory->createService($serviceManager);

        $this->assertInstanceOf('NewRelic\Client', $client);
    }
}