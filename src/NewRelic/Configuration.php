<?php
namespace NewRelic;

use Zend\Stdlib\AbstractOptions;

class Configuration extends AbstractOptions implements ConfigurationInterface
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
     * @var array
     */
    protected $ignoredTransactions = array();

    /**
     * @var array
     */
    protected $backgroundJobs = array();

    /**
     * {@inheritdoc}
     */
    public function setApplicationName($name)
    {
        $this->applicationName = (string) $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLicense($license)
    {
        $this->license = (string) $license;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * {@inheritdoc}
     */
    public function setBrowserTimingEnabled($enabled)
    {
        $this->browserTimingEnabled = (bool) $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBrowserTimingEnabled()
    {
        return $this->browserTimingEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setBrowserTimingAutoInstrument($enabled)
    {
        $this->browserTimingAutoInstrument = (bool) $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBrowserTimingAutoInstrument()
    {
        return $this->browserTimingAutoInstrument;
    }

    /**
     * {@inheritdoc}
     */
    public function setExceptionsLoggingEnabled($enabled)
    {
        $this->exceptionsLoggingEnabled = (bool) $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExceptionsLoggingEnabled()
    {
        return $this->exceptionsLoggingEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setIgnoredTransactions(array $transactions)
    {
        $this->ignoredTransactions = $transactions;
    }

    /**
     * {@inheritdoc}
     */
    public function getIgnoredTransactions()
    {
        return $this->ignoredTransactions;
    }

    /**
     * {@inheritdoc}
     */
    public function setBackgroundJobs(array $transactions)
    {
        $this->backgroundJobs = $transactions;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackgroundJobs()
    {
        return $this->backgroundJobs;
    }
}