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

    public function testSetExceptionsLoggingEnabled()
    {
        $this->configuration->setExceptionsLoggingEnabled(true);
        $this->assertTrue($this->configuration->getExceptionsLoggingEnabled());
    }

    public function testSetIgnoredTransactions()
    {
        $this->configuration->setIgnoredTransactions(array(
            'routes'      => array(),
            'controllers' => array(),
        ));

        $transactions = $this->configuration->getIgnoredTransactions();
        $this->assertInternalType('array', $transactions);
        $this->assertArrayHasKey('routes', $transactions);
        $this->assertArrayHasKey('controllers', $transactions);
    }

    public function testSetBackgroundJobs()
    {
        $this->configuration->setBackgroundJobs(array(
            'routes'      => array(),
            'controllers' => array(),
        ));

        $transactions = $this->configuration->getBackgroundJobs();
        $this->assertInternalType('array', $transactions);
        $this->assertArrayHasKey('routes', $transactions);
        $this->assertArrayHasKey('controllers', $transactions);
    }
}