<?php
namespace NewRelicTest\Factory;

use NewRelic\Factory\ErrorListenerFactory;
use Zend\Log\Logger;
use Zend\ServiceManager\ServiceManager;

class ErrorListenerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ErrorListenerFactory
     */
    protected $errorListenerFactory;

    public function setUp()
    {
        $this->errorListenerFactory = new ErrorListenerFactory();
    }

    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('NewRelic\Logger', new Logger());

        $listener = $this->errorListenerFactory->createService($serviceManager);
        $this->assertInstanceOf('NewRelic\Listener\ErrorListener', $listener);
    }
}