<?php
namespace NewRelic;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    protected $configuration;

    public function setUp()
    {
        $config = array(
            'application_name' => null,
            'license' => null,
            'browser_timing_enabled' => false,
            'browser_timing_auto_instrument' => true,
        );
        $this->configuration = new Configuration($config);
    }

    public function testSetApplicationName()
    {
        $this->configuration->setApplicationName('foo');
        $this->assertEquals('foo', $this->configuration->getApplicationName());
    }

    public function testSetLicense()
    {
        $this->configuration->setLicense('foo');
        $this->assertEquals('foo', $this->configuration->getLicense());
    }

    public function testSetBrowserTimingEnabled()
    {
        $this->configuration->setBrowserTimingEnabled(true);
        $this->assertTrue($this->configuration->getBrowserTimingEnabled());
    }

    public function testSetBrowserTimingAutoInstrument()
    {
        $this->configuration->setBrowserTimingAutoInstrument(true);
        $this->assertTrue($this->configuration->getBrowserTimingAutoInstrument());
    }
}