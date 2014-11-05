<?php
namespace NewRelicTest;

use NewRelic\ModuleOptions;

class ModuleOptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    public function setUp()
    {
        $this->moduleOptions = new ModuleOptions();
    }

    public function testSetApplicationName()
    {
        $this->assertEmpty($this->moduleOptions->getApplicationName());
        
        $this->moduleOptions->setApplicationName('foo');
        $this->assertEquals('foo', $this->moduleOptions->getApplicationName());
    }

    public function testSetLicense()
    {
        $this->assertEmpty($this->moduleOptions->getLicense());
        
        $this->moduleOptions->setLicense('foo');
        $this->assertEquals('foo', $this->moduleOptions->getLicense());
    }

    public function testSetBrowserTimingEnabled()
    {
        $this->assertFalse($this->moduleOptions->getBrowserTimingEnabled());
        
        $this->moduleOptions->setBrowserTimingEnabled(true);
        $this->assertTrue($this->moduleOptions->getBrowserTimingEnabled());
    }

    public function testSetBrowserTimingAutoInstrument()
    {
        $this->assertFalse($this->moduleOptions->getBrowserTimingAutoInstrument());
        
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

    public function testSetListeners()
    {
        $this->moduleOptions->setListeners(array('foo', 'bar', 'baz'));

        $listeners = $this->moduleOptions->getListeners();
        $this->assertCount(3, $listeners);
    }
}