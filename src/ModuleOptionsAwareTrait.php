<?php
namespace NewRelic;

use NewRelic\ModuleOptionsInterface;

trait ModuleOptionsAwareTrait
{
    /**
     * @var ModuleOptionsInterface
     */
    protected $options;

    /**
     * @param ModuleOptionsInterface $options
     */
    public function setModuleOptions(ModuleOptionsInterface $options)
    {
        $this->options = $options;
    }
}
