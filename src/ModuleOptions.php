<?php
namespace NewRelic;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /**
     * @var string
     */
    protected $applicationName;

    /**
     * @var string
     */
    protected $license;

    /**
     * @var bool
     */
    protected $browserTimingEnabled = false;

    /**
     * @var bool
     */
    protected $browserTimingAutoInstrument = false;

    /**
     * @var bool
     */
    protected $exceptionsLoggingEnabled = false;

    /**
     * @var array
     */
    protected $ignoredTransactions = [];

    /**
     * @var array
     */
    protected $backgroundJobs = [];

    /**
     * @var array
     */
    protected $ignoredApdex = [];

    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * @var string
     */
    protected $transactionNameProvider;

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

        return $this;
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

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackgroundJobs()
    {
        return $this->backgroundJobs;
    }

    /**
     * {@inheritdoc}
     */
    public function setIgnoredApdex(array $transactions)
    {
        $this->ignoredApdex = $transactions;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIgnoredApdex()
    {
        return $this->ignoredApdex;
    }

    /**
     * {@inheritdoc}
     */
    public function setListeners(array $listeners)
    {
        $this->listeners = $listeners;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getListeners()
    {
        return $this->listeners;
    }

    /**
     * {@inheritdoc}
     */
    public function setTransactionNameProvider($provider)
    {
        $this->transactionNameProvider = (string) $provider;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionNameProvider()
    {
        return $this->transactionNameProvider;
    }
}
