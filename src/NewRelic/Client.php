<?php
namespace NewRelic;

class Client implements ClientInterface
{
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
            return $this;
        }
        
        $params = array($name);

        if ($license) {
            $params['license'] = $license;
        }

        call_user_func_array('newrelic_set_appname', $params);
        
        return $this;
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
            return $this;
        }

        if (!$exception) {
            newrelic_notice_error($message);
        } else {
            newrelic_notice_error($message, $exception);
        }
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function nameTransaction($name)
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_name_transaction($name);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function endOfTransaction()
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_end_of_transaction();
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function ignoreTransaction()
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_ignore_transaction();
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function ignoreApdex()
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_ignore_apdex();
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function backgroundJob($flag = true)
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_background_job((bool) $flag);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function captureParams($enabled = true)
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_capture_params((bool) $enabled);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addCustomMetric($name, $value)
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_custom_metric($name, $value);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addCustomParameter($key, $value)
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_add_custom_parameter($key, $value);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addCustomTracer($name)
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_add_custom_tracer($name);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function disableAutorum()
    {
        if (!$this->extensionLoaded()) {
            return $this;
        }

        newrelic_disable_autorum();
        
        return $this;
    }
}