<?php
namespace NewRelic;

class ModuleOptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    public function setUp()
    {
        $config = array(
            'application_name' => null,
            'license' => null,
            'browser_timing_enabled' => false,
            'browser_timing_auto_instrument' => true,
        );
        $this->moduleOptions = new ModuleOptions($config);
    }

    public function testSetApplicationName()
    {
        $this->moduleOptions->setApplicationName('foo');
        $this->assertEquals('foo', $this->moduleOptions->getApplicationName());
    }

    public function testSetLicense()
    {
        $this->moduleOptions->setLicense('foo');
        $this->assertEquals('foo', $this->moduleOptions->getLicense());
    }

    public function testSetBrowserTimingEnabled()
    {
        $this->moduleOptions->setBrowserTimingEnabled(true);
        $this->assertTrue($this->moduleOptions->getBrowserTimingEnabled());
    }

    public function testSetBrowserTimingAutoInstrument()
    {
        $this->moduleOptions->setBrowserTimingAutoInstrument(true);
        $this->assertTrue($this->moduleOptions->getBrowserTimingAutoInstrument());
    }

    public function testSetExceptionsLoggingEnabled()
    {
        $this->moduleOptions->setExceptionsLoggingEnabled(true);
        $this->assertTrue($this->moduleOptions->getExceptionsLoggingEnabled());
    }

    public function testSetIgnoredTransactions()
    {
        $this->moduleOptions->setIgnoredTransactions(array(
            'routes'      => array(),
            'controllers' => array(),
        ));

        $transactions = $this->moduleOptions->getIgnoredTransactions();
        $this->assertInternalType('array', $transactions);
        $this->assertArrayHasKey('routes', $transactions);
        $this->assertArrayHasKey('controllers', $transactions);
    }

    public function testSetBackgroundJobs()
    {
        $this->moduleOptions->setBackgroundJobs(array(
            'routes'      => array(),
            'controllers' => array(),
        ));

        $transactions = $this->moduleOptions->getBackgroundJobs();
        $this->assertInternalType('array', $transactions);
        $this->assertArrayHasKey('routes', $transactions);
        $this->assertArrayHasKey('controllers', $transactions);
    }
}