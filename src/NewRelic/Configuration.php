<?php
namespace NewRelic;

use Zend\Stdlib\AbstractOptions;

class Configuration extends AbstractOptions
{
    /**
     * @var string
     */
    protected $applicationName = null;

    /**
     * @var string
     */
    protected $license = null;

    /**
     * @var boolean
     */
    protected $browserTimingEnabled;

    /**
     * @var boolean
     */
    protected $browserTimingAutoInstrument;

    /**
     * @var boolean
     */
    protected $exceptionsLoggingEnabled;

    /**
     * @param string $name
     * @return Configuration
     */
    public function setApplicationName($name)
    {
        $this->applicationName = (string) $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }

    /**
     * @param string $license
     * @return Configuration
     */
    public function setLicense($license)
    {
        $this->license = (string) $license;

        return $this;
    }

    /**
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @param boolean $enabled
     * @return Configuration
     */
    public function setBrowserTimingEnabled($enabled)
    {
        $this->browserTimingEnabled = (bool) $enabled;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getBrowserTimingEnabled()
    {
        return $this->browserTimingEnabled;
    }

    /**
     * @param boolean $enabled
     * @return Configuration
     */
    public function setBrowserTimingAutoInstrument($enabled)
    {
        $this->browserTimingAutoInstrument = (bool) $enabled;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getBrowserTimingAutoInstrument()
    {
        return $this->browserTimingAutoInstrument;
    }

    /**
     * @param boolean $enabled
     * @return Configuration
     */
    public function setExceptionsLoggingEnabled($enabled)
    {
        $this->exceptionsLoggingEnabled = (bool) $enabled;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getExceptionsLoggingEnabled()
    {
        return $this->exceptionsLoggingEnabled;
    }
}