<?php
namespace NewRelic;

interface ModuleOptionsAwareInterface
{
    /**
     * @param ModuleOptionsInterface $options
     */
    public function setModuleOptions(ModuleOptionsInterface $options);
}