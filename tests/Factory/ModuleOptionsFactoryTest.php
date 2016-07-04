<?php
namespace NewRelicTest\Factory;

use Interop\Container\ContainerInterface;
use NewRelic\Factory\ModuleOptionsFactory;
use NewRelic\ModuleOptions;

class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->get('Config')->willReturn([
            'newrelic' => [
                'application_name' => null,
                'license' => null,
                'browser_timing_enabled' => false,
                'browser_timing_auto_instrument' => true,
            ],
        ]);
        $moduleOptionsFactory = new ModuleOptionsFactory();

        $moduleOptions = $moduleOptionsFactory($container->reveal());

        $this->assertInstanceOf(ModuleOptions::class, $moduleOptions);
    }

    /**
     * @expectedException \NewRelic\Exception\RuntimeException
     */
    public function testCreateServiceWithoutConfig()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->get('Config')->willReturn([]);
        $moduleOptionsFactory = new ModuleOptionsFactory();

        $moduleOptionsFactory($container->reveal());
    }
}
