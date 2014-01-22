<?php
namespace NewRelic;

interface ConfigurationInterface
{
    /**
     * @param  string $name
     * @return self
     */
    public function setApplicationName($name);

    /**
     * @return string
     */
    public function getApplicationName();

    /**
     * @param  string $license
     * @return self
     */
    public function setLicense($license);

    /**
     * @return string
     */
    public function getLicense();

    /**
     * @param  bool $enabled
     * @return self
     */
    public function setBrowserTimingEnabled($enabled);

    /**
     * @return bool
     */
    public function getBrowserTimingEnabled();

    /**
     * @param  bool $enabled
     * @return self
     */
    public function setBrowserTimingAutoInstrument($enabled);

    /**
     * @return bool
     */
    public function getBrowserTimingAutoInstrument();

    /**
     * @param  bool $enabled
     * @return self
     */
    public function setExceptionsLoggingEnabled($enabled);

    /**
     * @return bool
     */
    public function getExceptionsLoggingEnabled();

    /**
     * @param  array $transactions
     * @return self
     */
    public function setIgnoredTransactions(array $transactions);

    /**
     * @return array
     */
    public function getIgnoredTransactions();

    /**
     * @param  array $transactions
     * @return self
     */
    public function setBackgroundJobs(array $transactions);

    /**
     * @return array
     */
    public function getBackgroundJobs();
}