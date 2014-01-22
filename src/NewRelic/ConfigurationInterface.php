<?php
namespace NewRelic;

interface ConfigurationInterface
{
    /**
     * @param string $name
     * @return ConfigurationInterface
     */
    public function setApplicationName($name);

    /**
     * @return string
     */
    public function getApplicationName();

    /**
     * @param string $license
     * @return ConfigurationInterface
     */
    public function setLicense($license);

    /**
     * @return string
     */
    public function getLicense();

    /**
     * @param boolean $enabled
     * @return ConfigurationInterface
     */
    public function setBrowserTimingEnabled($enabled);

    /**
     * @return boolean
     */
    public function getBrowserTimingEnabled();

    /**
     * @param boolean $enabled
     * @return ConfigurationInterface
     */
    public function setBrowserTimingAutoInstrument($enabled);

    /**
     * @return boolean
     */
    public function getBrowserTimingAutoInstrument();

    /**
     * @param boolean $enabled
     * @return ConfigurationInterface
     */
    public function setExceptionsLoggingEnabled($enabled);

    /**
     * @return boolean
     */
    public function getExceptionsLoggingEnabled();

    /**
     * @param array $transactions
     * @return ConfigurationInterface
     */
    public function setIgnoredTransactions(array $transactions);

    /**
     * @return array
     */
    public function getIgnoredTransactions();

    /**
     * @param array $transactions
     * @return ConfigurationInterface
     */
    public function setBackgroundJobs(array $transactions);

    /**
     * @return array
     */
    public function getBackgroundJobs();
}