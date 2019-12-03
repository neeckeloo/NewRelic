<?php
namespace NewRelic;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /**
     * @var string|null
     */
    protected $applicationName;

    /**
     * @var string|null
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
     * @var string|null
     */
    protected $transactionNameProvider;

    public function setApplicationName(string $name = null): ModuleOptionsInterface
    {
        $this->applicationName = $name;

        return $this;
    }

    public function getApplicationName(): ?string
    {
        return $this->applicationName;
    }

    public function setLicense(string $license = null): ModuleOptionsInterface
    {
        $this->license = $license;

        return $this;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setBrowserTimingEnabled(bool $enabled): ModuleOptionsInterface
    {
        $this->browserTimingEnabled = $enabled;

        return $this;
    }

    public function getBrowserTimingEnabled(): bool
    {
        return $this->browserTimingEnabled;
    }

    public function setBrowserTimingAutoInstrument(bool $enabled): ModuleOptionsInterface
    {
        $this->browserTimingAutoInstrument = $enabled;

        return $this;
    }

    public function getBrowserTimingAutoInstrument(): bool
    {
        return $this->browserTimingAutoInstrument;
    }

    public function setExceptionsLoggingEnabled(bool $enabled): ModuleOptionsInterface
    {
        $this->exceptionsLoggingEnabled = $enabled;

        return $this;
    }

    public function getExceptionsLoggingEnabled(): bool
    {
        return $this->exceptionsLoggingEnabled;
    }

    public function setIgnoredTransactions(array $transactions): ModuleOptionsInterface
    {
        $this->ignoredTransactions = $transactions;

        return $this;
    }

    public function getIgnoredTransactions(): array
    {
        return $this->ignoredTransactions;
    }

    public function setBackgroundJobs(array $transactions): ModuleOptionsInterface
    {
        $this->backgroundJobs = $transactions;

        return $this;
    }

    public function getBackgroundJobs(): array
    {
        return $this->backgroundJobs;
    }

    public function setIgnoredApdex(array $transactions): ModuleOptionsInterface
    {
        $this->ignoredApdex = $transactions;

        return $this;
    }

    public function getIgnoredApdex(): array
    {
        return $this->ignoredApdex;
    }

    public function setListeners(array $listeners): ModuleOptionsInterface
    {
        $this->listeners = $listeners;

        return $this;
    }

    public function getListeners(): array
    {
        return $this->listeners;
    }

    public function setTransactionNameProvider(string $provider): ModuleOptionsInterface
    {
        $this->transactionNameProvider = $provider;

        return $this;
    }

    public function getTransactionNameProvider(): ?string
    {
        return $this->transactionNameProvider;
    }
}
