<?php
namespace NewRelic;

use Zend\EventManager\Event;

class Client
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @param Configuration $configuration
     */
    public function __construct($configuration)
    {
        $this->setConfiguration($configuration);
    }

    /**
     * @param Configuration $configuration
     * @return Client
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Returns true if newrelic extension is loaded.
     *
     * @return boolean
     */
    public function extensionLoaded()
    {
        return extension_loaded('newrelic');
    }

    /**
     * Sets the name of the application.
     *
     * @param string $name
     * @param string $license
     */
    public function setAppName($name, $license = null)
    {
        if (!$this->extensionLoaded()) {
            return;
        }
        
        $params = array($name);

        if ($license) {
            $params['license'] = $license;
        }

        call_user_func_array('newrelic_set_appname', $params);
    }

    /**
     * Returns the JavaScript string to inject as part of the header for browser timing.
     *
     * @param boolean $flag This indicates whether or not surrounding script tags should be returned as part of the string.
     */
    public function getBrowserTimingHeader($flag = true)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        return newrelic_get_browser_timing_header((bool) $flag);
    }

    /**
     * Returns the JavaScript string to inject as part of the footer for browser timing.
     *
     * @param boolean $flag This indicates whether or not surrounding script tags should be returned as part of the string.
     */
    public function getBrowserTimingFooter($flag = true)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        return newrelic_get_browser_timing_footer((bool) $flag);
    }

    /**
     * Reports an error at this line of code, with complete stack trace.
     *
     * @param string $message
     * @param string $exception
     */
    public function noticeError($message, $exception = null)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        if (!$exception) {
            newrelic_notice_error($message);
        } else {
            newrelic_notice_error($message, $exception);
        }
    }

    /**
     * Sets the name of the transaction.
     *
     * @param string $name
     */
    public function nameTransaction($name)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_name_transaction($name);
    }

    /**
     * Stop recording the web transaction immediately.
     */
    public function endOfTransaction()
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_end_of_transaction();
    }

    /**
     * Do not generate metrics for this transaction.
     */
    public function ignoreTransaction()
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_ignore_transaction();
    }

    /**
     * Do not generate Adpex metrics for this transaction.
     */
    public function ignoreApdex()
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_ignore_apdex();
    }

    /**
     * Whether to mark as a background job or web application.
     *
     * @param boolean $flag
     */
    public function backgroundJob($flag = true)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_background_job((bool) $flag);
    }

    /**
     * Enable/disable capturing of URL parameters for displaying in transaction traces.
     *
     * @param boolean $enabled
     */
    public function captureParams($enabled = true)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_capture_params((bool) $enabled);
    }

    /**
     * Adds a custom metric with the specified name and value.
     * 
     * @param string $name
     * @param mixed $value
     */
    public function addCustomMetric($name, $value)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_custom_metric($name, $value);
    }

    /**
     * Add a custom parameter to the current web transaction with the specified value.
     *
     * @param string $key
     * @param mixed $value
     */
    public function addCustomParameter($key, $value)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_add_custom_parameter($key, $value);
    }

    /**
     * Add user defined functions or methods to the list to be instrumented.
     * 
     * @param string $name
     */
    public function addCustomTracer($name)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_add_custom_tracer($name);
    }

    /**
     * Prevents output filter from attempting to insert RUM Javascript.
     */
    public function disableAutorum()
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_disable_autorum();
    }
}