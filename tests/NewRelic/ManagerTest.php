<?php
namespace NewRelic;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Manager
     */
    protected $manager;

    public function setUp()
    {
        $this->manager = new Manager();
    }

    public function testSetApplicationName()
    {
        $this->manager->setApplicationName('foo');
        $this->assertEquals('foo', $this->manager->getApplicationName());
    }

    public function testSetApplicationLicense()
    {
        $this->manager->setApplicationLicense('foo');
        $this->assertEquals('foo', $this->manager->getApplicationLicense());
    }

    public function testSetBrowserTimingEnabled()
    {
        $this->manager->setBrowserTimingEnabled(true);
        $this->assertTrue($this->manager->getBrowserTimingEnabled());
    }

    public function testSetBrowserTimingAutoInstrument()
    {
        $this->manager->setBrowserTimingAutoInstrument(true);
        $this->assertTrue($this->manager->getBrowserTimingAutoInstrument());
    }
}