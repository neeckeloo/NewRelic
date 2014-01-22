<?php
namespace NewRelic;

interface ClientInterface
{
    /**
     * @param  ConfigurationInterface $configuration
     * @return self
     */
    public function setConfiguration(ConfigurationInterface $configuration);

    /**
     * @return ConfigurationInterface
     */
    public function getConfiguration();

    /**
     * Returns true if newrelic extension is loaded.
     *
     * @return bool
     */
    public function extensionLoaded();

    /**
     * Sets the name of the application.
     *
     * @param string $name
     * @param string $license
     */
    public function setAppName($name, $license = null);

    /**
     * Returns the JavaScript string to inject as part of the header for browser timing.
     *
     * @param bool $flag This indicates whether or not surrounding script tags should be returned as part of the string.
     */
    public function getBrowserTimingHeader($flag = true);

    /**
     * Returns the JavaScript string to inject as part of the footer for browser timing.
     *
     * @param bool $flag This indicates whether or not surrounding script tags should be returned as part of the string.
     */
    public function getBrowserTimingFooter($flag = true);

    /**
     * Reports an error at this line of code, with complete stack trace.
     *
     * @param string $message
     * @param string $exception
     */
    public function noticeError($message, $exception = null);

    /**
     * Sets the name of the transaction.
     *
     * @param string $name
     */
    public function nameTransaction($name);

    /**
     * Stop recording the web transaction immediately.
     */
    public function endOfTransaction();

    /**
     * Do not generate metrics for this transaction.
     */
    public function ignoreTransaction();

    /**
     * Do not generate Adpex metrics for this transaction.
     */
    public function ignoreApdex();

    /**
     * Whether to mark as a background job or web application.
     *
     * @param bool $flag
     */
    public function backgroundJob($flag = true);

    /**
     * Enable/disable capturing of URL parameters for displaying in transaction traces.
     *
     * @param bool $enabled
     */
    public function captureParams($enabled = true);

    /**
     * Adds a custom metric with the specified name and value.
     *
     * @param string $name
     * @param mixed $value
     */
    public function addCustomMetric($name, $value);

    /**
     * Add a custom parameter to the current web transaction with the specified value.
     *
     * @param string $key
     * @param mixed $value
     */
    public function addCustomParameter($key, $value);

    /**
     * Add user defined functions or methods to the list to be instrumented.
     *
     * @param string $name
     */
    public function addCustomTracer($name);

    /**
     * Prevents output filter from attempting to insert RUM Javascript.
     */
    public function disableAutorum();
}