<?php
namespace NewRelic;

class Client implements ClientInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @param ConfigurationInterface $configuration
     */
    public function __construct($configuration)
    {
        $this->setConfiguration($configuration);
    }

    /**
     * {@inheritdoc}
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function extensionLoaded()
    {
        return extension_loaded('newrelic');
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getBrowserTimingHeader($flag = true)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        return newrelic_get_browser_timing_header((bool) $flag);
    }

    /**
     * {@inheritdoc}
     */
    public function getBrowserTimingFooter($flag = true)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        return newrelic_get_browser_timing_footer((bool) $flag);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function nameTransaction($name)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_name_transaction($name);
    }

    /**
     * {@inheritdoc}
     */
    public function endOfTransaction()
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_end_of_transaction();
    }

    /**
     * {@inheritdoc}
     */
    public function ignoreTransaction()
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_ignore_transaction();
    }

    /**
     * {@inheritdoc}
     */
    public function ignoreApdex()
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_ignore_apdex();
    }

    /**
     * {@inheritdoc}
     */
    public function backgroundJob($flag = true)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_background_job((bool) $flag);
    }

    /**
     * {@inheritdoc}
     */
    public function captureParams($enabled = true)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_capture_params((bool) $enabled);
    }

    /**
     * {@inheritdoc}
     */
    public function addCustomMetric($name, $value)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_custom_metric($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function addCustomParameter($key, $value)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_add_custom_parameter($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function addCustomTracer($name)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_add_custom_tracer($name);
    }

    /**
     * {@inheritdoc}
     */
    public function disableAutorum()
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        newrelic_disable_autorum();
    }
}